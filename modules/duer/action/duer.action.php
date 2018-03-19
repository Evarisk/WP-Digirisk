<?php
/**
 * Gères l'action AJAX de la génération du DUER
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
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
	 * @since 6.2.1
	 * @version 6.5.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_display_societies_duer', array( $this, 'callback_display_societies_duer' ) );
		add_action( 'wp_ajax_construct_duer', array( $this, 'callback_ajax_construct_duer' ) );
		add_action( 'wp_ajax_generate_duer', array( $this, 'callback_ajax_generate_duer' ) );
		add_action( 'wp_ajax_generate_establishment', array( $this, 'callback_ajax_generate_establishment' ) );
		add_action( 'wp_ajax_generate_zip', array( $this, 'callback_ajax_generate_zip' ) );
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

		ZIP_Class::g()->clear_temporarly_files_details();

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
	 * Cette méthode construit les données du DUER.
	 *
	 * @since 6.2.3
	 * @version 6.5.0
	 *
	 * @return void
	 */
	public function callback_ajax_construct_duer() {
		check_ajax_referer( 'construct_duer' );

		$response = array(
			'namespace'         => 'digirisk',
			'module'            => 'DUER',
			'callback_success'  => 'generatedDUERSuccess',
			'index'             => 1,
			'creation_response' => array(),
		);

		$parent_id             = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$start_audit_date      = ! empty( $_POST['dateDebutAudit'] ) ? sanitize_text_field( $_POST['dateDebutAudit'] ) : '';
		$end_audit_date        = ! empty( $_POST['dateFinAudit'] ) ? sanitize_text_field( $_POST['dateFinAudit'] ) : '';
		$recipient             = ! empty( $_POST['destinataireDUER'] ) ? sanitize_text_field( $_POST['destinataireDUER'] ) : '';
		$methodology           = ! empty( $_POST['methodologie'] ) ? sanitize_text_field( $_POST['methodologie'] ) : '';
		$sources               = ! empty( $_POST['sources'] ) ? sanitize_text_field( $_POST['sources'] ) : '';
		$availability_of_plans = ! empty( $_POST['dispoDesPlans'] ) ? sanitize_text_field( $_POST['dispoDesPlans'] ) : '';
		$important_note        = ! empty( $_POST['remarqueImportante'] ) ? sanitize_text_field( $_POST['remarqueImportante'] ) : '';

		if ( empty( $parent_id ) ) {
			wp_send_json_error();
		}

		$build_args = array(
			'element_id'         => $parent_id,
			'dateDebutAudit'     => $start_audit_date,
			'dateFinAudit'       => $end_audit_date,
			'destinataire'       => $recipient,
			'methodologie'       => $sources,
			'dispoDesPlans'      => $availability_of_plans,
			'remarqueImportante' => $important_note,
		);

		\eoxia\LOG_Util::log( 'DEBUT - Construction des données du DUER en BDD', 'digirisk' );
		$generation_status = DUER_Document_Class::g()->generate( $build_args );
		\eoxia\LOG_Util::log( 'FIN - Construction des données du DUER en BDD', 'digirisk' );

		$response['duer_document_id'] = $generation_status['creation_response']['id'];

		wp_send_json_success( $response );
	}

	/**
	 * Génères le DUER
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @return void
	 */
	public function callback_ajax_generate_duer() {
		check_ajax_referer( 'generate_duer' );

		$response = array(
			'namespace'         => 'digirisk',
			'module'            => 'DUER',
			'callback_success'  => 'generatedDUERSuccess',
			'index'             => ! empty( $_POST['index'] ) ? (int) $_POST['index'] : 0,
			'creation_response' => array(),
		);

		$document_id = ! empty( $_POST['duer_document_id'] ) ? (int) $_POST['duer_document_id'] : 0;
		$parent_id   = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;

		if ( empty( $document_id ) || empty( $parent_id ) ) {
			wp_send_json_error();
		}

		$society          = Society_Class::g()->get( array( 'id' => $parent_id ), true );
		$current_document = DUER_Class::g()->get( array( 'id' => $document_id ), true );

		\eoxia\LOG_Util::log( 'DEBUT - Génération du document DUER', 'digirisk' );
		$generation_status = Document_Class::g()->generate_document( $current_document->model_id, $current_document->document_meta, $society->type . '/' . $society->id . '/' . $current_document->title );
		\eoxia\LOG_Util::log( 'FIN - Génération du document DUER', 'digirisk' );

		ZIP_Class::g()->update_temporarly_files_details( array(
			'filename' => $current_document->title,
			'path'     => $generation_status['path'],
		) );

		wp_send_json_success( $response );
	}

	/**
	 * Génères un document de fiche de groupement ou bien de fiche de poste.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @return void
	 */
	public function callback_ajax_generate_establishment() {
		check_ajax_referer( 'generate_establishment' );

		$response = array(
			'namespace'         => 'digirisk',
			'module'            => 'DUER',
			'callback_success'  => 'generatedDUERSuccess',
			'index'             => ! empty( $_POST['index'] ) ? (int) $_POST['index'] : 0,
			'creation_response' => array(),
		);

		$element_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$society    = Society_Class::g()->get( array( 'id' => $element_id ), true );

		if ( Group_Class::g()->get_type() === $society->type ) {
			\eoxia\LOG_Util::log( 'DEBUT - Génération du document groupement #GP' . $element_id, 'digirisk' );
			$generation_status = Sheet_Groupment_Class::g()->generate( $element_id );
			\eoxia\LOG_Util::log( 'FIN - Génération du document groupement', 'digirisk' );
		} elseif ( Workunit_Class::g()->get_type() === $society->type ) {
			\eoxia\LOG_Util::log( 'DEBUT - Génération du document fiche de poste #UT' . $element_id, 'digirisk' );
			$generation_status = Sheet_Workunit_Class::g()->generate( $element_id );
			\eoxia\LOG_Util::log( 'FIN - Génération du document fiche de poste', 'digirisk' );
		}

		ZIP_Class::g()->update_temporarly_files_details( array(
			'filename' => $generation_status['creation_response']['filename'],
			'path'     => $generation_status['creation_response']['path'],
		) );

		wp_send_json_success( $response );
	}

	/**
	 * Génères le ZIP de tous les documents du DUER courant.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @return void
	 */
	public function callback_ajax_generate_zip() {
		check_ajax_referer( 'generate_zip' );

		$response = array(
			'namespace'         => 'digirisk',
			'module'            => 'DUER',
			'callback_success'  => 'generatedDUERSuccess',
			'index'             => ! empty( $_POST['index'] ) ? (int) $_POST['index'] : 0,
			'creation_response' => array(),
		);

		$element_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;

		$element = Society_Class::g()->get( array(
			'id' => $element_id,
		), true );

		\eoxia\LOG_Util::log( 'DEBUT - Génération du ZIP', 'digirisk' );
		$generate_response = ZIP_Class::g()->generate( $element );
		\eoxia\LOG_Util::log( 'FIN - Génération du ZIP', 'digirisk' );

		$response['end'] = true;
		wp_send_json_success( $response );
	}
}

new DUER_Action();
