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
	public function __construct() {
		/**	Création d'une taille d'image dédiée pour les images principales des groupements et unités de travail / Create a deddicated picture size for groups and word unit pictures	*/
		add_image_size( 'digirisk-element-thumbnail', 200, 150, true );
		/**	Création d'une taille d'image dédiée pour les images principales des groupements et unités de travail / Create a deddicated picture size for groups and word unit pictures	*/
		add_image_size( 'digirisk-element-miniature', 50, 50, true );
	}
}
