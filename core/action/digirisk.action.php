<?php

namespace digi;

/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package core
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class digirisk_action {

	/**
	* Le constructeur ajoutes les actions WordPress suivantes:
	* admin_enqueue_scripts (Pour appeller les scripts JS et CSS dans l'admin)
	* admin_print_scripts (Pour appeler les scripts JS en bas du footer)
	* plugins_loaded (Pour appeler le domaine de traduction)
	*/
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'callback_before_admin_enqueue_scripts' ), 10 );
		add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts' ), 11 );

		add_action( 'plugins_loaded', array( $this, 'callback_plugins_loaded' ) );
	}

	public function callback_before_admin_enqueue_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-form' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_media();
	}

	public function callback_admin_enqueue_scripts() {
		wp_register_style( 'digi-style', PLUGIN_URL . 'core/assets/css/style.min.css', array(), config_util::$init['digirisk']->version );
	  wp_enqueue_style( 'digi-style' );

		 wp_enqueue_script( 'digi-script', PLUGIN_URL . 'core/assets/js/backend.min.js', array(), config_util::$init['digirisk']->version, false );
	}
	/**
	* Appelle le domaine de traduction
	*/
	public function callback_plugins_loaded() {
		load_plugin_textdomain( "digirisk", false, PLUGIN_PATH . 'core\assets\languages\\' );
	}
}

new digirisk_action();
