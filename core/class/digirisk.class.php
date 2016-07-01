<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal de l'extension digirisk pour wordpress / Main controller file for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal de l'extension digirisk pour wordpress / Main controller class for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class digirisk_class {

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	function __construct() {
		/**	Création d'une taille d'image dédiée pour les images principales des groupements et unités de travail / Create a deddicated picture size for groups and word unit pictures	*/
		add_image_size( 'digirisk-element-thumbnail', 200, 150, true );
		/**	Création d'une taille d'image dédiée pour les images principales des groupements et unités de travail / Create a deddicated picture size for groups and word unit pictures	*/
		add_image_size( 'digirisk-element-miniature', 50, 50, true );
	}

	/**
	 * Lors de l'activation de l'extension on créé les contenus par défaut and lance des actions spécifiques / When plugin is activated create default content and run some specific action
	 *
	 */
	public function activation() {
		/**	A l'activation de l'extension principale on créé une variable d'environnement pour l'installateur /	On plugin main activation create an environnement var for installer */
		set_transient( '_wpdigi_installer', 1, 30 );

		/**	Lancement des actions automatique lors de l'activation de l'extension / Do extra automatic action on main plugin activation	*/
		do_action( 'wp_digi_activation_hook' );
	}

}
