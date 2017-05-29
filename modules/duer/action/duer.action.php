<?php
/**
 * Gères l'action AJAX de la génération du DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.9.0
 * @copyright 2015-2016 Evarisk
 * @package document
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères l'action AJAX de la génération du DUER
 */
class DUER_Action {

	/**
	 * Le constructeur
	 */
	function __construct() {
		add_action( 'wp_ajax_display_societies_duer', array( $this, 'callback_display_societies_duer' ) );
		add_action( 'wp_ajax_generate_duer', array( $this, 'callback_ajax_generate_duer' ) );
	}


	/**
	 * Appelle la méthode display_societies_tree de DUER_Class pour récupérer la vue dans la tamporisation de sortie.
	 *
	 * @return void
	 *
	 * @since 6.2.3.0
	 * @version 6.2.9.0
	 */
	public function callback_display_societies_duer() {
		check_ajax_referer( 'display_societies_duer' );

		delete_user_meta( get_current_user_id(), Config_Util::$init['duer']->meta_key_generate_duer );

		$society_id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		if ( empty( $society_id ) ) {
			wp_send_json_error();
		}

		$society = Group_Class::g()->get( array( 'post__in' => array( $society_id ) ) );
		$society = $society[0];

		ob_start();
		View_Util::exec( 'duer', 'tree/main', array(
			'society' => $society,
		) );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'DUER',
			'callback_success' => 'displayedSocietyDUERSuccess',
			'view' => ob_get_clean(),
		) );
	}

	/**
	 * La méthode qui gère la réponse de la requête.
	 * Cette méthode appelle la méthode generate de DUER_Generate_Class.
	 *
	 * @return void
	 *
	 * @since 6.2.3.0
	 * @version 6.2.4.0
	 */
	public function callback_ajax_generate_duer() {
		check_ajax_referer( 'callback_ajax_generate_duer' );

		$meta_generate_duer = get_user_meta( get_current_user_id(), Config_Util::$init['duer']->meta_key_generate_duer, true );
		$end = false;

		if ( empty( $meta_generate_duer ) ) {
			$meta_generate_duer = array();
		}

		if ( ! empty( $_POST['duer'] ) ) {
			$generate_response = DUER_Generate_Class::g()->generate( $_POST );
		} elseif ( ! empty( $_POST['generate_duer'] ) ) {
			$document_id = ! empty( $_POST ) && is_int( (int) $_POST['element_id'] ) && ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
			if ( ! empty( $document_id ) ) {
				$parent_id = ! empty( $_POST ) && is_int( (int) $_POST['parent_id'] ) && ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;
				$parent_element = society_class::g()->show_by_type( $parent_id );

				$current_document = DUER_Class::g()->get( array( 'post__in' => array( $document_id ), 'post_status' => 'any' ) );
			 	$generate_response = document_class::g()->generate_document( $current_document[0]->model_id, $current_document[0]->document_meta, $parent_element->type . '/' . $parent_id . '/' . $current_document[0]->title . '.odt' );
			}
		} elseif ( ! empty( $_POST['zip'] ) ) {
			$element = Group_Class::g()->get( array( 'post__in' => array( $_POST['element_id'] ) ) );
			$element = $element[0];
			$generate_response = ZIP_Class::g()->generate( $element, $meta_generate_duer );
			$end = true;

			// C'est sur que c'est le 0 le DUER.
			$duer = DUER_Class::g()->get( array( 'post__in' => array( $meta_generate_duer[0]['id'] ), 'post_status' => array( 'publish', 'inherit' ) ) );
			$duer = $duer[0];
			$duer->zip_path = $generate_response['zip_path'];
			DUER_Class::g()->update( $duer );

			delete_user_meta( get_current_user_id(), Config_Util::$init['duer']->meta_key_generate_duer );
		} else {
			$post_type = get_post_type( $_POST['society_id'] );

			if ( 'digi-group' === $post_type ) {
				$generate_response = Fiche_De_Groupement_Class::g()->generate( $_POST['society_id'] );
			} elseif ( 'digi-workunit' === $post_type ) {
				$generate_response = Fiche_De_Poste_Class::g()->generate( $_POST['society_id'] );
			}
		}

		$response = array(
			'namespace' => 'digirisk',
			'module' => 'DUER',
			'index' => ! empty( $_POST['index'] ) ? (int) $_POST['index'] : 0,
			'creation_response' => ! empty( $generate_response ) && ! empty( $generate_response['creation_response'] ) ? $generate_response['creation_response'] : '',
		);

		if ( $end ) {
			$response['end'] = true;
		} else {
			if ( ! empty( $generate_response['creation_response'] ) ) {
				$meta_generate_duer[] = $generate_response['creation_response'];
				update_user_meta( get_current_user_id(), Config_Util::$init['duer']->meta_key_generate_duer, $meta_generate_duer );
			}
		}

		if ( $generate_response['success'] ) {
			$response['callback_success'] = 'generatedDUERSuccess';
			$response['index']++;
		} else {
			$response['callback_error'] = 'callback_generate_duer_error';
		}

		wp_send_json_success( $response );
	}
}

new DUER_Action();
