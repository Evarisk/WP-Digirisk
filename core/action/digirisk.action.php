<?php
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
	*
	*/
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( include_util::g(), 'callback_before_admin_enqueue_scripts' ), 10 );
		add_action( 'admin_enqueue_scripts', array( include_util::g(), 'callback_admin_enqueue_scripts' ), 11 );
		add_action( 'admin_print_scripts', array( include_util::g(), 'callback_admin_print_scripts' ) );

		add_action( 'plugins_loaded', array( $this, 'callback_plugins_loaded' ) );
	}

	/**
	* Appelle le domaine de traduction
	*/
	public function callback_plugins_loaded() {
		load_plugin_textdomain( "digirisk", false, WPDIGI_DIR . '/core/assets/languages/' );
	}
}

new digirisk_action();
