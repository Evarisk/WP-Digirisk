<?php
/**
 * Les actions relatives à la sauvegarde des risques.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actiosn relatives à la sauvegarde des risques
 */
class Risk_Save_Action {

	/**
	 * Le constructeur appelle la méthode personnalisé: save_risk
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_action( 'save_risk', array( $this, 'callback_save_risk' ), 10, 1 );
	}

	/**
	 * Enregistres un risque.
	 * Ce callback est appelé après le callback callback_save_risk de risk_evaluation_action
	 *
	 * @param Risk_Model $risk Les données du risque.
	 *
	 * @since 0.1
	 * @version 6.2.6.0
	 */
	public function callback_save_risk( $risk ) {
		$parent_id = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;

		if ( isset( $risk['id'] ) ) {
			$danger = Danger_Class::g()->get( array( 'include' => $risk['danger_id'] ) );
			$danger = $danger[0];

			$image_id = 0;

			if ( ! empty( $risk['associated_document_id'] ) ) {
				$image_id = $risk['associated_document_id']['image'][0];
			}

			$risk['title'] = $danger->name;
			$risk['parent_id'] = $parent_id;
			$risk['taxonomy']['digi-danger'][] = $danger->id;
			$risk['taxonomy']['digi-danger-category'][] = $danger->parent_id;
			$risk_obj = Risk_Class::g()->update( $risk );

			if ( ! $risk_obj ) {
				wp_send_json_error();
			}

			$risk_evaluation = Risk_Evaluation_Class::g()->update( array(
				'id' => $risk_obj->current_evaluation_id,
				'post_id' => $risk_obj->id,
			) );

			if ( ! $risk_evaluation ) {
				wp_send_json_error();
			}

			if ( empty( $image_id ) && ! empty( $_POST['associated_document_id']['image'][0] ) ) {
				$image_id = (int) $_POST['associated_document_id']['image'][0];
			}

			if ( ! empty( $image_id ) ) {
				File_Management_Class::g()->associate_file( $image_id, $risk_obj->id, 'risk_class', 'digi' );
			}
		}

		do_action( 'save_risk_evaluation_comment', $risk_obj, $risk );
	}
}

new Risk_Save_Action();
