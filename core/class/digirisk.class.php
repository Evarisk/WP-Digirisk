<?php
/**
 * Classe gérant le boot de l'application DigiRisk.
 * Appelle la vue permettant d'afficher la navigation.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package core
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Classe gérant le boot de l'application DigiRisk.
 * Appelle la vue permettant d'afficher la navigation
 */
class Digirisk_Class extends Singleton_Util {

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
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function display( $id = 0 ) {
		require( PLUGIN_DIGIRISK_PATH . '/core/view/main.view.php' );
	}
}

new Digirisk_Class();
