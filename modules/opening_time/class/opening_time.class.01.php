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
class opening_time_class_01 {

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	function __construct() {
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_assets' ) );
	}

	/**
	 * Déclaration des scripts et styles / Enqueue scripts and styles
	 *
	 * @uses wp_register_style
	 * @uses wp_enqueue_style
	 * @uses wp_enqueue_script
	 */
	public function admin_assets() {
		wp_enqueue_script( 'jquery.timepicker.min.js', OPENING_TIME_URL . 'asset/js/jquery.timepicker.min.js', array( 'jquery', 'jquery-form', 'jquery-ui-datepicker', 'jquery-ui-autocomplete', 'suggest' ), OPENING_TIME_VERSION, false );
		wp_enqueue_script( 'opening-time-backend-js', OPENING_TIME_URL . 'asset/js/backend.js', array( 'jquery', 'jquery-form', 'jquery-ui-datepicker', 'jquery-ui-autocomplete', 'suggest' ), OPENING_TIME_VERSION, false );

    wp_register_style( 'jquery.timepicker.css', OPENING_TIME_URL . 'asset/css/jquery.timepicker.css', array(), OPENING_TIME_VERSION );
		wp_enqueue_style( 'jquery.timepicker.css' );
  }
}

new opening_time_class_01();
