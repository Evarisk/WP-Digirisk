<?php
/**
 * Classe principale de DigiRisk
 * Contient la méthode qui fait l'affichage principale de DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Classe gérant le boot de l'application DigiRisk.
 * Appelle la vue permettant d'afficher la navigation
 */
class Digirisk extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 */
	protected function construct() {
		add_image_size( 'digirisk-element-thumbnail', 200, 150, true );
		add_image_size( 'digirisk-element-miniature', 50, 50, true );
	}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * $request_uri est utilisé
	 *
	 * @since 6.0.0
	 *
	 * @param integer $id L'ID de la société à afficher.
	 */
	public function display( $id = 0 ) {
		$request_uri     = ! empty( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : ''; // WPCS: input var ok, CSRF ok.
		$waiting_updates = get_option( '_digi_waited_updates', array() );

		require PLUGIN_DIGIRISK_PATH . '/core/view/main.view.php';
	}

	/**
	 * Affiches le contenu principale de l'application.
	 *
	 * @since 7.0.0
	 *
	 * @param  integer $id L'ID de la société.
	 */
	public function display_main_container( $id = 0 ) {
		if ( 0 === $id ) {
			$society = Society_Class::g()->get_current_society();
		} else {
			$society = Society_Class::g()->show_by_type( $id );
		}

		$tab_data = Tab_Class::g()->build_tab_to_display( $society );

		require PLUGIN_DIGIRISK_PATH . '/core/view/main-content.view.php';
	}

	/**
	 * Récupères le patch note pour la version actuelle.
	 *
	 * @since 6.3.0
	 *
	 * @return array
	 */
	public function get_patch_note() {
		$patch_note_url = 'https://www.evarisk.com/wp-json/eoxia/v1/change_log/' . \eoxia\Config_Util::$init['digirisk']->version;

		$json = wp_remote_get( $patch_note_url, array(
			'headers' => array(
				'Content-Type' => 'application/json',
			),
			'verify_ssl' => false,
		) );


		$result = __( 'No update notes for this version.', 'digirisk' );

		if ( ! is_wp_error( $json ) && ! empty( $json ) && ! empty( $json['body'] ) ) {
			$result = json_decode( $json['body'] );
		}

		return array(
			'status'  => is_wp_error( $json ) ? false : true,
			'content' => $result,
		);
	}

	/**
	 * Ajoutes la capacité "manage_digirisk" à l'activation de DigiRisk.
	 *
	 * @since 6.0.0
	 */
	public function activation() {
		/** Set capability to administrator by default */
		$admin_role = get_role( 'administrator' );
		if ( ! $admin_role->has_cap( 'manage_digirisk' ) ) {
			$admin_role->add_cap( 'manage_digirisk' );
		}
	}
}

new Digirisk();
