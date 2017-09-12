<?php
/**
 * Classe gérant le boot de l'application DigiRisk.
 * Appelle la vue permettant d'afficher la navigation.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 6.3.0
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
	 * @since 0.1
	 * @version 6.2.3.0
	 */
	protected function construct() {
		/**	Création d'une taille d'image dédiée pour les images principales des groupements et unités de travail / Create a deddicated picture size for groups and word unit pictures	*/
		add_image_size( 'digirisk-element-thumbnail', 200, 150, true );
		/**	Création d'une taille d'image dédiée pour les images principales des groupements et unités de travail / Create a deddicated picture size for groups and word unit pictures	*/
		add_image_size( 'digirisk-element-miniature', 50, 50, true );
	}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * @param integer $id L'ID de la société à afficher.
	 *
	 * @return void
	 *
	 * @since 0.1.0
	 * @version 6.2.4
	 */
	public function display( $id = 0 ) {
		require( PLUGIN_DIGIRISK_PATH . '/core/view/main.view.php' );
	}

	/**
	 * Récupères le patch note pour la version actuelle.
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 *
	 * @return string|object
	 */
	public function get_patch_note() {
		$patch_note_url = 'https://www.evarisk.com/wp-json/wp/v2/change_log/33014';
		$json = wp_remote_get( $patch_note_url, array(
			'headers' => array(
				'Content-Type' => 'application/json',
			),
		) );

		$result = __( 'Aucune note de mise à jour pour cette version.', 'digirisk' );

		if ( ! empty( $json['body'] ) ) {
			$result = json_decode( $json['body'] );
		}

		return $result;
	}
	/**
	 * Launch some action when activate the plugin
	 */
	public function activation() {
		/** Set capability to administrator by default */
		$admin_role = get_role( 'administrator' );
		if ( ! $admin_role->has_cap( 'manage_digirisk' ) ) {
			$admin_role->add_cap( 'manage_digirisk' );
		}

		update_option( \eoxia\Config_Util::$init['digirisk']->key_last_update_version, (int) str_replace( '.', '', \eoxia\Config_Util::$init['digirisk']->version ) );
	}

}

new Digirisk_Class();
