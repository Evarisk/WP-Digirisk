<?php
/**
 * Gestion des shortcodes pour gérer l'affichage des modèles personnalisés
 *
 * @since 6.1.5.5
 * @version 6.2.3.0
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion des shortcodes pour gérer l'affichage des modèles personnalisés
 */
class Handle_Model_Shortcode {

	/**
	 * Le constructeur ajoutes le shortcode digi-handle-model
	 */
	public function __construct() {
		add_shortcode( 'digi-handle-model', array( $this, 'callback_handle_model_interface' ) );
	}

	/**
	 * Appelle la méthode display de Handle_Model_Class
	 *
	 * @param array $param Les paramètres du shortcode / Shortcode parameters.
	 *
	 * @return void
	 */
	public function callback_handle_model_interface( $param ) {
		Handle_Model_Class::g()->display();
	}

}

new Handle_Model_Shortcode();
