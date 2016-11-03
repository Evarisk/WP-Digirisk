<?php namespace digi;
/**
* Ajoutes un shortcode qui permet d'afficher le formulaire pour importer des utilisateurs depuis un fichier .csv
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package user
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class user_import_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'digi-import-user', array( $this, 'callback_digi_import_user' ) );
	}

	/**
	* Appelle la fonction render de \digi\user_import_class
	*
	* @param array $param
	*/
	public function callback_digi_import_user( $param ) {
		\digi\user_import_class::g()->render();
	}
}

new user_import_shortcode();
