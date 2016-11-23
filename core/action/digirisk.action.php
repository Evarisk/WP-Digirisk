<?php
/**
 * Initialise les fichiers .config.json
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialise les scripts JS et CSS du Plugin
 * Ainsi que le fichier MO
 */
class Digirisk_Action {

	/**
	 * Le constructeur ajoutes les actions WordPress suivantes:
	 * admin_enqueue_scripts (Pour appeller les scripts JS et CSS dans l'admin)
	 * admin_print_scripts (Pour appeler les scripts JS en bas du footer)
	 * plugins_loaded (Pour appeler le domaine de traduction)
	 */
	public function __construct() {
		// Initialises ses actions que si nous sommes sur une des pages réglés dans le fichier digirisk.config.json dans la clé "insert_scripts_pages".
		$page = ( ! empty( $_REQUEST['page'] ) ) ? sanitize_text_field( $_REQUEST['page'] ) : '';

		if ( in_array( $page, config_util::$init['digirisk']->insert_scripts_pages, true ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_before_admin_enqueue_scripts' ), 10 );
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts' ), 11 );
			add_action( 'admin_print_scripts', array( $this, 'callback_admin_print_scripts' ) );
		}

		add_action( 'init', array( $this, 'callback_plugins_loaded' ) );
	}

	/**
	 * Initialise les fichiers JS inclus dans WordPress (jQuery, wp.media et thickbox)
	 *
	 * @return void nothing
	 */
	public function callback_before_admin_enqueue_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-form' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_media();
		add_thickbox();
	}

	/**
	 * Initialise le fichier style.min.css et backend.min.js du plugin DigiRisk.
	 *
	 * @return void nothing
	 */
	public function callback_admin_enqueue_scripts() {
		wp_register_style( 'digi-style', PLUGIN_DIGIRISK_URL . 'core/assets/css/style.min.css', array(), config_util::$init['digirisk']->version );
		wp_enqueue_style( 'digi-style' );

		wp_enqueue_style( 'digi-datepicker', PLUGIN_DIGIRISK_URL . 'core/assets/css/datepicker.min.css', array(), config_util::$init['digirisk']->version );

		wp_enqueue_script( 'digi-script', PLUGIN_DIGIRISK_URL . 'core/assets/js/backend.min.js', array(), config_util::$init['digirisk']->version, false );
	}

	/**
	 * Initialise en php le fichier permettant la traduction des variables string JavaScript.
	 *
	 * @return void nothing
	 */
	public function callback_admin_print_scripts() {
		require( PLUGIN_DIGIRISK_PATH . '/core/assets/js/define-string.js.php' );
	}

	/**
	 * Initialise le fichier MO
	 */
	public function callback_plugins_loaded() {
		load_plugin_textdomain( 'digirisk', false, PLUGIN_DIGIRISK_DIR . '/core/assets/languages/' );
	}
}

new Digirisk_Action();
