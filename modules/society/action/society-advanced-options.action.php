<?php
/**
 * Gestion de la requête AJAX pour enregistrer les options avancées des sociétés.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.5.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion de la requête AJAX pour enregistrer les options avancées des sociétés.
 */
class Society_Advanced_Options_Action {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_action( 'wp_ajax_advanced_options_move_to', array( $this, 'callback_advanced_options_move_to' ) );
	}

	/**
	 * Changes le parent_id de la société puis l'enregistre.
	 * Afin renvoie le template de l'application en entier.
	 *
	 * @since 6.2.5.0
	 * @version 6.2.9.0
	 *
	 * @return void
	 */
	public function callback_advanced_options_move_to() {
		check_ajax_referer( 'advanced_options_move_to' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$parent_id = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;

		if ( 0 === $id || 0 === $parent_id ) {
			wp_send_json_error();
		}

		$society = Society_Class::g()->show_by_type( $id );
		$society->parent_id = $parent_id;
		Society_Class::g()->update_by_type( $society );

		ob_start();
		Digirisk_Class::g()->display( $id );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'societyAdvancedOptions',
			'callback_success' => 'savedAdvancedOptionsMoveTo',
			'view' => ob_get_clean(),
		) );
	}
}

new Society_Advanced_Options_Action();
