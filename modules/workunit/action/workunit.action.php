<?php
/**
 * Les actions relatives aux unités de travail.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatifs aux unités de travail.
 */
class Workunit_Action {

	/**
	 * CORE - Instanciation des actions ajax pour les unités de travail / Instanciate ajax treatment for work unit
	 */
	public function __construct() {
		/**	Création d'une unité de travail / Create a work unit	*/
		add_action( 'wp_ajax_save_workunit', array( $this, 'ajax_save_workunit' ) );
	}

	/**
	 * Enregistrement d'une unité de travail.
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function ajax_save_workunit() {
		/**	Check if the ajax request come from a known source	*/
		check_ajax_referer( 'save_workunit', 'wpdigi_nonce' );

		if ( empty( $_POST['workunit'] ) ) {
			wp_send_json_error();
		}

		if ( 0 === (int) $_POST['groupment_id'] ) {
			wp_send_json_error();
		} else {
			$parent_id = (int) $_POST['groupment_id'];
		}

		$workunit = array(
			'title' => sanitize_text_field( $_POST['workunit']['title'] ),
			'parent_id' => $parent_id,
		);

		/**	Création de l'unité / Create the unit	*/
		$element = workunit_class::g()->create( $workunit );

		ob_start();
		Digirisk_Class::g()->display();
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'workunit',
			'callback_success' => 'saved_workunit_success',
			'template' => ob_get_clean(),
			'id' => $element->id,
		) );
	}

}

new Workunit_Action();
