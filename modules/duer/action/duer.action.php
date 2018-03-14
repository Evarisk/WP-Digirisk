<?php
/**
 * Gères l'action AJAX de la génération du DUER
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
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
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_display_societies_duer', array( $this, 'callback_display_societies_duer' ) );
		add_action( 'wp_ajax_generate_duer', array( $this, 'callback_ajax_generate_duer' ) );
	}


	/**
	 * Appelle la méthode display_societies_tree de DUER_Class pour récupérer la vue dans la tamporisation de sortie.
	 *
	 * @return void
	 *
	 * @since 6.2.3
	 * @version 6.5.0
	 */
	public function callback_display_societies_duer() {
		check_ajax_referer( 'display_societies_duer' );

		delete_user_meta( get_current_user_id(), \eoxia\Config_Util::$init['digirisk']->duer->meta_key_generate_duer );

		$society_id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		if ( empty( $society_id ) ) {
			wp_send_json_error();
		}

		$society = Society_Class::g()->get( array(
			'id' => $society_id,
		), true );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'duer', 'tree/main', array(
			'society' => $society,
		) );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'DUER',
			'callback_success' => 'displayedSocietyDUERSuccess',
			'view'             => ob_get_clean(),
		) );
	}

	/**
	 * La méthode qui gère la réponse de la requête.
	 * Cette méthode appelle la méthode generate de DUER_Generate_Class.
	 *
	 * @since 6.2.3
	 * @version 6.5.0
	 *
	 * @return void
	 * @todo: 24/01/2018: Déplacer dans la méthode "generate" dans le fichier duer-generate.class.php
	 */
	public function callback_ajax_generate_duer() {
		check_ajax_referer( 'callback_ajax_generate_duer' );

		$meta_generate_duer = get_user_meta( get_current_user_id(), \eoxia\Config_Util::$init['digirisk']->duer->meta_key_generate_duer, true );
		$end                = false;

		if ( empty( $meta_generate_duer ) ) {
			$meta_generate_duer = array();
		}

		if ( ! empty( $_POST['duer'] ) ) {
			\eoxia\LOG_Util::log( 'DEBUT - Génération des données du DUER en BDD', 'digirisk' );
			$generate_response = DUER_Generate_Class::g()->generate( $_POST );
			\eoxia\LOG_Util::log( 'FIN - Génération des données du DUER en BDD', 'digirisk' );
		} elseif ( ! empty( $_POST['generate_duer'] ) ) {
			$document_id = ! empty( $_POST ) && is_int( (int) $_POST['element_id'] ) && ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
			if ( ! empty( $document_id ) ) {
				$parent_id      = ! empty( $_POST ) && is_int( (int) $_POST['parent_id'] ) && ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;
				$parent_element = Society_Class::g()->show_by_type( $parent_id );

				$current_document = DUER_Class::g()->get( array( 'id' => $document_id ), true );

				\eoxia\LOG_Util::log( 'DEBUT - Génération du document DUER', 'digirisk' );
				$generate_response = Document_Class::g()->generate_document( $current_document->model_id, $current_document->document_meta, $parent_element->type . '/' . $parent_id . '/' . $current_document->title . '.odt' );
				\eoxia\LOG_Util::log( 'FIN - Génération du document DUER', 'digirisk' );
			}
		} elseif ( ! empty( $_POST['zip'] ) ) {
			$element = Society_Class::g()->get( array(
				'id' => $_POST['element_id'],
			), true );
			\eoxia\LOG_Util::log( 'DEBUT - Génération du ZIP', 'digirisk' );
			$generate_response = ZIP_Class::g()->generate( $element, $meta_generate_duer );
			\eoxia\LOG_Util::log( 'FIN - Génération du ZIP', 'digirisk' );
			$end = true;

			// C'est sur que c'est le 0 le DUER.
			$duer           = DUER_Class::g()->get( array( 'id' => $meta_generate_duer[0]['id'] ), true );
			$duer->zip_path = $generate_response['zip_path'];
			DUER_Class::g()->update( $duer );

			delete_user_meta( get_current_user_id(), \eoxia\Config_Util::$init['digirisk']->duer->meta_key_generate_duer );
		} else {
			$post_type = get_post_type( $_POST['society_id'] );

			if ( Group_Class::g()->get_type() === $post_type ) {
				\eoxia\LOG_Util::log( 'DEBUT - Génération du document groupement #GP' . $_POST['society_id'], 'digirisk' );
				$generate_response = Sheet_Groupment_Class::g()->generate( $_POST['society_id'] );
				\eoxia\LOG_Util::log( 'FIN - Génération du document groupement', 'digirisk' );
			} elseif ( Workunit_Class::g()->get_type() === $post_type ) {
				\eoxia\LOG_Util::log( 'DEBUT - Génération du document unité de travail #U' . $_POST['society_id'], 'digirisk' );
				$generate_response = Sheet_Workunit_Class::g()->generate( $_POST['society_id'] );
				\eoxia\LOG_Util::log( 'FIN - Génération du document unité de travail', 'digirisk' );
			} else {
				$generate_response = array(
					'success' => true,
				);
			}
		}

		$response = array(
			'namespace'         => 'digirisk',
			'module'            => 'DUER',
			'index'             => ! empty( $_POST['index'] ) ? (int) $_POST['index'] : 0,
			'creation_response' => ! empty( $generate_response ) && ! empty( $generate_response['creation_response'] ) ? $generate_response['creation_response'] : '',
		);

		if ( $end ) {
			$response['end'] = true;
		} else {
			if ( ! empty( $generate_response['creation_response'] ) ) {
				$meta_generate_duer[] = $generate_response['creation_response'];
				update_user_meta( get_current_user_id(), \eoxia\Config_Util::$init['digirisk']->duer->meta_key_generate_duer, $meta_generate_duer );
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
