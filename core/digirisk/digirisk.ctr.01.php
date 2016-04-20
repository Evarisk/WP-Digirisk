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
class digirisk_controller_01 {

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	function __construct() {
		/**	Création d'une taille d'image dédiée pour les images principales des groupements et unités de travail / Create a deddicated picture size for groups and word unit pictures	*/
		add_image_size( 'digirisk-element-thumbnail', 200, 150, true );
		/**	Création d'une taille d'image dédiée pour les images principales des groupements et unités de travail / Create a deddicated picture size for groups and word unit pictures	*/
		add_image_size( 'digirisk-element-miniature', 50, 50, true );

		/**	Appel des scripts et styles pour le module digirisk dans la partie administration / Include styles and scripts for backend	*/
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_assets' ) );
		/**	Appel des scripts communs pour le module digirisk / Include common styles and scripts	*/
		add_action( 'admin_enqueue_scripts', array( &$this, 'common_js' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'common_js' ), 8);
		/*	Ajoute du contenu JS dans le header des pages	*/
		add_action( 'admin_print_scripts', array( &$this, 'admin_print_scripts' ), 11 );
	}

	/**
	 * Déclaration des scripts et styles / Enqueue scripts and styles
	 *
	 * @uses wp_register_style
	 * @uses wp_enqueue_style
	 * @uses wp_enqueue_script
	 */
	public function admin_assets() {
		/**	Styles inclusion	*/
		wp_register_style( 'wpdigi-admin-styles', WPDIGI_URL . 'core/assets/css/style.min.css', array( 'dashicons' ), WPDIGI_VERSION );
		wp_enqueue_style( 'wpdigi-admin-styles' );

		wp_register_style( 'wpdigi-jquery-ext-styles', WPDIGI_URL . 'core/assets/css/jquery-ui.css', '', WPDIGI_VERSION );
		wp_enqueue_style( 'wpdigi-jquery-ext-styles' );

		/**	Scripts inclusion */
		wp_enqueue_script( 'wpdigi-backend-js', WPDIGI_URL . 'core/assets/js/backend.js', array( 'jquery', 'jquery-form', 'jquery-ui-datepicker', 'jquery-ui-autocomplete', 'suggest' ), WPDIGI_VERSION, false );
	}

	/**
	 * Inclusion des scripts permettant l'utilisation de Angular JS dans le module / Include scripts for using Angular JS into module
	 */
	public function common_js() {
		//wp_enqueue_script( 'wpdigi-angularjs', WPDIGI_URL . 'core/assets/js/angular.js', '', WPDIGI_VERSION, false );
	}

	/**
	 * Inclusion d'un script dans le header des pages avec des définitions de variables / Include javascripts into all header pages with global var definition
	 */
	public function admin_print_scripts() {
		require_once( wpdigi_utils::get_template_part( WPDIGI_DIR, WPDIGI_PATH, 'core/assets/js', 'header.js') );
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
