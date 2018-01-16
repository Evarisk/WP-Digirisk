<?php
/**
 * Classe gérant le boot de l'application DigiRisk.
 * Appelle la vue permettant d'afficher la navigation.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.1
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant le boot de l'application DigiRisk.
 * Appelle la vue permettant d'afficher la navigation
 */
class Digirisk_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 */
	protected function construct() {
		// Création de différentes tailles d'image dédiée pour les images principales des groupements et unités de travail.
		add_image_size( 'digirisk-element-thumbnail', 200, 150, true );
		add_image_size( 'digirisk-element-miniature', 50, 50, true );
	}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * @param integer $id L'ID de la société à afficher.
	 *
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 */
	public function display( $id = 0 ) {
		require PLUGIN_DIGIRISK_PATH . '/core/view/main.view.php';
	}

	/**
	 * Récupères le patch note pour la version actuelle.
	 *
	 * @since 6.3.0
	 * @version 6.4.1
	 *
	 * @return string|object
	 */
	public function get_patch_note() {
		$patch_note_url = 'https://www.evarisk.com/wp-json/eoxia/v1/change_log/' . \eoxia\Config_Util::$init['digirisk']->version;

		$json = wp_remote_get( $patch_note_url, array(
			'headers' => array(
				'Content-Type' => 'application/json',
			),
		) );

		$result = __( 'Aucune note de mise à jour pour cette version.', 'digirisk' );

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
	 * @version 6.4.0
	 */
	public function activation() {
		/** Set capability to administrator by default */
		$admin_role = get_role( 'administrator' );
		if ( ! $admin_role->has_cap( 'manage_digirisk' ) ) {
			$admin_role->add_cap( 'manage_digirisk' );
		}
	}
}

new Digirisk_Class();
