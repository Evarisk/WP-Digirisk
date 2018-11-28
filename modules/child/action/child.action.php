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

		register_rest_route( 'digi/v1', '/duer/tree', array(
			'methods'  => 'GET',
			'callback' => array( $this, 'callback_duer_tree' ),
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

	public function callback_duer_tree( \WP_REST_Request $request ) {
		$society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$societies = Society_Class::g()->get_societies_in( $society->data['id'], 'inherit' );

		$response = new \WP_REST_Response( $societies );

		return $response;
	}
}

new Child_Action();
