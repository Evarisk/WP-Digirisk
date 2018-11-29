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
		register_rest_route( 'digi/v1', '/register-site', array(
			'methods'  => 'POST',
			'callback' => array( $this, 'callback_register_site' ),
		) );

		register_rest_route( 'digi/v1', '/duer/generate', array(
			'methods'  => 'GET',
			'callback' => array( $this, 'callback_generate' ),
		) );
	}

	public function callback_register_site( \WP_REST_Request $request ) {
		$check_fields = array(
			'url'        => 'esc_url_raw',
			'login'      => 'sanitize_user',
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

		$string_to_hash = implode( '', $data );
		$string_to_hash = hash( 'sha256', $string_to_hash );
		update_option( \eoxia\Config_Util::$init['digirisk']->child->site_parent_key, $string_to_hash );

		$response = new \WP_REST_Response( array(
			'title' => get_bloginfo( 'name' ),
		) );

		if ( $unique_security_id['security_id'] !== $data['unique_key'] ) {
			$response->set_status( 404 );
		} else {
			$response->set_status( 200 );
		}


		return $response;
	}

	public function callback_generate( \WP_REST_Request $request ) {
		$parent    = Society_Class::g()->get( array( 'posts_per_page' => 1 ), true );
		$parent_id = $parent->data['id'];
		$links     = array();

		$generation_status = DUER_Class::g()->generate_full_duer( $parent_id, '', '', '', '', '', '', '' );
		$links[]           = $generation_status['document']->data['link'];

		$societies = Society_Class::g()->get_societies_in( $parent_id, 'inherit' );

		if ( ! empty( $societies ) ) {
			foreach ( $societies as $society ) {
				$societies = array_merge( $societies, Society_Class::g()->get_societies_in( $society->data['id'], 'inherit' ) );
			}
		}

		if ( ! empty( $societies ) ) {
			foreach ( $societies as $society ) {
				if ( Group_Class::g()->get_type() === $society->data['type'] ) {
					\eoxia\LOG_Util::log( 'DEBUT - Génération du document groupement #GP' . $element_id, 'digirisk' );
					$generation_status = Sheet_Groupment_Class::g()->prepare_document( $society, array(
						'parent' => $society,
					) );
					$links[]           = $generation_status['document']->data['link'];

					Sheet_Groupment_Class::g()->create_document( $generation_status['document']->data['id'] );
					\eoxia\LOG_Util::log( 'FIN - Génération du document groupement', 'digirisk' );
				} elseif ( Workunit_Class::g()->get_type() === $society->data['type'] ) {
					\eoxia\LOG_Util::log( 'DEBUT - Génération du document fiche de poste #UT' . $element_id, 'digirisk' );
					$generation_status = Sheet_Workunit_Class::g()->prepare_document( $society, array(
						'parent' => $society,
					) );
					$links[]           = $generation_status['document']->data['link'];

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
