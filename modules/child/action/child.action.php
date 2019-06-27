<?php
/**
 * Classe gérant les actions des enfants (Liaison avec DigiRisk Dashboard)
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Actions
 *
 * @since     7.1.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Child Action class.
 */
class Child_Action {

	/**
	 * Construct
	 *
	 * @since 7.1.0
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'callback_rest_api_init' ) );
	}

	public function callback_rest_api_init() {
		register_rest_route( 'digi/v1', '/statut', array(
			'methods'  => 'POST',
			'callback' => array( $this, 'callback_status' ),
		) );

		register_rest_route( 'digi/v1', '/register-site', array(
			'methods'  => 'POST',
			'callback' => array( $this, 'callback_register_site' ),
		) );

		register_rest_route( 'digi/v1', '/delete-site', array(
			'methods'  => 'POST',
			'callback' => array( $this, 'callback_delete_site' ),
		) );

		register_rest_route( 'digi/v1', '/duer/society', array(
			'methods'  => 'POST',
			'callback' => array( $this, 'callback_get_society' ),
		) );

		register_rest_route( 'digi/v1', '/duer/society/tree/(?P<id>\d+)', array(
			'methods'  => 'POST',
			'callback' => array( $this, 'callback_get_society_tree' ),
		) );

		register_rest_route( 'digi/v1', '/duer/risk/(?P<id>\d+)', array(
			'methods'  => 'POST',
			'callback' => array( $this, 'callback_get_risk' ),
		) );

		register_rest_route( 'digi/v1', '/duer/generate', array(
			'methods'  => 'POST',
			'callback' => array( $this, 'callback_generate' ),
		) );
	}

	public function callback_status( \WP_REST_Request $request ) {
		$params = $request->get_params();

		if ( ! Child_Class::g()->check_hash( $params['hash'] ) ) {
			$response = new \WP_REST_Response( '', 404 );
			return $response;
		}

		return new \WP_REST_Response( true );
	}

	public function callback_register_site( \WP_REST_Request $request ) {
		$check_fields = array(
			'url_parent' => 'esc_url_raw',
			'url'        => 'esc_url_raw',
			'unique_key' => 'sanitize_text_field',
		);

		$data   = array();
		$params = $request->get_params();

		if ( ! empty( $check_fields ) ) {
			foreach ( $check_fields as $key => $value ) {
				$data[ $key ] = call_user_func( $value, $params[ $key ] );
			}
		}

		$unique_security_id = get_option( \eoxia\Config_Util::$init['digirisk']->child->security_id_key, false );
		$site_key           = \eoxia\Config_Util::$init['digirisk']->child->site_parent_key;
		$sites              = get_option( $site_key, array() );

		$last_id = 0;

		$already_exist = false;

		if ( ! empty( $sites ) ) {
			foreach ( $sites as $id => $site ) {
				if ( $data['url_parent'] == $site['url_parent'] ) {
					$already_exist = true;
				}

				$last_id = $id;
			}
		}

		$response = new \WP_REST_Response( array(
			'title' => get_bloginfo( 'name' ),
		) );

		if ( $unique_security_id['security_id'] !== $data['unique_key'] ) {
			$response->set_status( 200 );
			$response->data['error_code'] = 1;
		} else {
			if ( ! $already_exist ) {
				$url_parent = $data['url_parent'];

				unset( $data['url_parent'] );

				$string_to_hash = implode( '', $data );
				$string_to_hash = hash( 'sha256', $string_to_hash );

				$sites[ $last_id + 1 ] = array(
					'url'        => $data['url'],
					'url_parent' => $url_parent,
					'hash'       => $string_to_hash,
				);

				update_option( $site_key, $sites );
			} else {
				$response->data['error_code'] = 2;
			}

			$response->set_status( 200 );
		}


		return $response;
	}

	public function callback_delete_site( \WP_REST_Request $request ) {
		$params = $request->get_params();

		$status = Child_Class::g()->delete_site_by_hash( $params['hash'] );

		$response = new \WP_REST_Response( $status );
		return $response;
	}

	public function callback_get_society( \WP_REST_Request $request ) {
		$params = $request->get_params();

		if ( ! Child_Class::g()->check_hash( $params['hash'] ) ) {
			$response = new \WP_REST_Response( '', 404 );
			return $response;
		}

		$parent   = Society_Class::g()->get( array( 'posts_per_page' => 1 ), true );
		$response = new \WP_REST_Response( $parent->data );

		return $response;
	}

	public function callback_get_society_tree( \WP_REST_Request $request ) {
		$params = $request->get_params();

		$parent    = Society_Class::g()->get( array( 'posts_per_page' => 1 ), true );
		$parent_id = $parent->data['id'];
		$args['parent_id']    = $parent_id;
		$args['dashboard_id'] = $params['id'];

		if ( ! Child_Class::g()->check_hash( $params['hash'] ) ) {
			$response = new \WP_REST_Response( '', 404 );
			return $response;
		}

		$data = DUER_Class::g()->get_hierarchy_duer( $params, $args );
		array_unshift( $data['elementParHierarchie']['value'], array(
			'nomElement' => 'S' . $params['id'] . ' - ' . $parent->data['title'],
		) );

		$response = new \WP_REST_Response( $data );
		return $response;
	}

	public function callback_get_risk( \WP_REST_Request $request ) {
		$params       = $request->get_params();
		$dashboard_id = $params['id'];

		if ( ! Child_Class::g()->check_hash( $params['hash'] ) ) {
			$response = new \WP_REST_Response( '', 404 );
			return $response;
		}

		$args_where = array(
			'post_status'    => array( 'inherit', 'publish' ),
			'meta_key'       => '_wpdigi_equivalence',
			'orderby'        => 'meta_value_num',
			'meta_query' => array(
				array(
					'key'     => '_wpdigi_preset',
					'value'   => 1,
					'compare' => '!=',
				)
			)
		);

		$risks = Risk_Class::g()->get( $args_where );
		$data = array();

		if ( ! empty( $risks ) ) {
			foreach ( $risks as &$risk ) {
				if ( 0 !== $risk->data['parent_id'] && ! empty( $risk->data['parent'] ) && get_post_status( $risk->data['parent_id'] ) != 'trash' ) {
					$output_comment = '';
					if ( ! empty( $risk->data['comment'] ) ) {
						foreach ( $risk->data['comment'] as $comment ) {
							$output_comment .= point_to_string( $comment );
						}
					}

					$risk = Corrective_Task_Class::g()->output_odt( $risk );
					$data[] = array(
						'nomElement'                  => 'S' . $dashboard_id . ' -- ' . $risk->data['parent']->data['unique_identifier'] . ' - ' . $risk->data['parent']->data['title'],
						'identifiantRisque'           => $risk->data['unique_identifier'] . ' - ' . $risk->data['evaluation']->data['unique_identifier'],
						'quotationRisque'             => $risk->data['current_equivalence'],
						'scale'                       => $risk->data['evaluation']->data['scale'],
						'nomDanger'                   => $risk->data['risk_category']->data['name'],
						'commentaireRisque'           => $output_comment,
						'actionPreventionUncompleted' => $risk->data['output_action_prevention_uncompleted'],
						'actionPreventionCompleted'   => $risk->data['output_action_prevention_completed'],
					);
				}
			}
		}

		$response = new \WP_REST_Response( $data );
		return $response;
	}

	public function callback_generate( \WP_REST_Request $request ) {
		$params = $request->get_params();
		if ( ! Child_Class::g()->check_hash( $params['hash'] ) ) {
			$response = new \WP_REST_Response( $params['hash'], 404 );
			return $response;
		}

		$parent    = Society_Class::g()->get( array( 'posts_per_page' => 1 ), true );
		$parent_id = $parent->data['id'];
		$links     = array();

		// $generation_status = DUER_Class::g()->generate_full_duer( $parent_id, '', '', '', '', '', '', '' );
		// $links[] = array(
		// 	'link'  => $generation_status['document']->data['link'],
		// 	'title' => $generation_status['document']->data['title'],
		// );

		$societies = Society_Class::g()->get_societies_in( $parent_id, 'inherit' );

		if ( ! empty( $societies ) ) {
			foreach ( $societies as $society ) {
				$societies = array_merge( $societies, Society_Class::g()->get_societies_in( $society->data['id'], 'inherit' ) );
			}
		}

		if ( ! empty( $societies ) ) {
			foreach ( $societies as $society ) {
				if ( Group_Class::g()->get_type() === $society->data['type'] ) {
					$generation_status = Sheet_Groupment_Class::g()->prepare_document( $society, array(
						'parent' => $society,
					) );
					$links[] = array(
						'link'  => $generation_status['document']->data['link'],
						'title' => $generation_status['document']->data['title'],
					);

					Sheet_Groupment_Class::g()->create_document( $generation_status['document']->data['id'] );
					\eoxia\LOG_Util::log( 'FIN - Génération du document groupement', 'digirisk' );
				} elseif ( Workunit_Class::g()->get_type() === $society->data['type'] ) {
					$generation_status = Sheet_Workunit_Class::g()->prepare_document( $society, array(
						'parent' => $society,
					) );
					$links[] = array(
						'link'  => $generation_status['document']->data['link'],
						'title' => $generation_status['document']->data['title'],
					);

					Sheet_Workunit_Class::g()->create_document( $generation_status['document']->data['id'] );
					\eoxia\LOG_Util::log( 'FIN - Génération du document fiche de poste', 'digirisk' );
				}
			}
		}

		$response = new \WP_REST_Response( $links );

		return $response;
	}
}

new Child_Action();
