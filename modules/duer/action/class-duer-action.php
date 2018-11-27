<?php
/**
 * Classe gérant les actions pour les DUER.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.1
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * DUER Action class.
 */
class DUER_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.1
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
	 * @since   6.2.3
	 */
	public function callback_display_societies_duer() {
		check_ajax_referer( 'display_societies_duer' );

		ZIP_Class::g()->clear_temporarly_files_details();

		$society_id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.

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
		$view = ob_get_clean();

		ob_start();
		?>
		<div class="wpeo-button button-main modal-close">
			<span><?php esc_html_e( 'Fermer', 'digirisk' ); ?></span>
		</div>
		<?php
		$buttons_view = ob_get_clean();
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'DUER',
			'callback_success' => 'displayedSocietyDUERSuccess',
			'view'             => $view,
			'buttons_view'     => $buttons_view,
		) );
	}

	/**
	 * Cette méthode construit les données du DUER.
	 *
	 * @since 6.2.3
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

		$parent_id           = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0; // WPCS: input var ok.
		$date_debut_audit    = ! empty( $_POST['dateDebutAudit'] ) ? sanitize_text_field( wp_unslash( $_POST['dateDebutAudit'] ) ) : ''; // WPCS: input var ok.
		$date_fin_audit      = ! empty( $_POST['dateFinAudit'] ) ? sanitize_text_field( wp_unslash( $_POST['dateFinAudit'] ) ) : ''; // WPCS: input var ok.
		$destinataire_duer   = ! empty( $_POST['destinataireDUER'] ) ? sanitize_textarea_field( wp_unslash( $_POST['destinataireDUER'] ) ) : ''; // WPCS: input var ok.
		$methodologie        = ! empty( $_POST['methodologie'] ) ? sanitize_textarea_field( wp_unslash( $_POST['methodologie'] ) ) : ''; // WPCS: input var ok.
		$sources             = ! empty( $_POST['sources'] ) ? sanitize_textarea_field( wp_unslash( $_POST['sources'] ) ) : ''; // WPCS: input var ok.
		$dispo_des_plans     = ! empty( $_POST['dispoDesPlans'] ) ? sanitize_textarea_field( wp_unslash( $_POST['dispoDesPlans'] ) ) : ''; // WPCS: input var ok.
		$remarque_importante = ! empty( $_POST['remarqueImportante'] ) ? sanitize_textarea_field( wp_unslash( $_POST['remarqueImportante'] ) ) : ''; // WPCS: input var ok.

		if ( empty( $parent_id ) ) {
			wp_send_json_error();
		}

		$society = Society_Class::g()->show_by_type( $parent_id );

		\eoxia\LOG_Util::log( 'DEBUT - Construction des données du DUER en BDD', 'digirisk' );
		$data = DUER_Class::g()->prepare_document( $society, array(
			'parent_id'           => 0,
			'date_debut_audit'    => $date_debut_audit,
			'date_fin_audit'      => $date_fin_audit,
			'destinataire_duer'   => $destinataire_duer,
			'methodologie'        => $methodologie,
			'sources'             => $sources,
			'dispo_des_plans'     => $dispo_des_plans,
			'remarque_importante' => $remarque_importante,
		) );
		\eoxia\LOG_Util::log( 'FIN - Construction des données du DUER en BDD', 'digirisk' );

		$response['duer_document_id'] = $data['document']->data['id'];

		wp_send_json_success( $response );
	}

	/**
	 * Génères le DUER
	 *
	 * @since 6.5.0
	 */
	public function callback_ajax_generate_duer() {
		check_ajax_referer( 'generate_duer' );

		$index       = ! empty( $_POST['index'] ) ? (int) $_POST['index'] : 0; // WPCS: input var ok.
		$document_id = ! empty( $_POST['duer_document_id'] ) ? (int) $_POST['duer_document_id'] : 0; // WPCS: input var ok.
		$society_id  = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0; // WPCS: input var ok.

		$response = array(
			'namespace'         => 'digirisk',
			'module'            => 'DUER',
			'callback_success'  => 'generatedDUERSuccess',
			'index'             => $index,
			'creation_response' => array(),
			'element_id'        => $society_id,
			'duer_document_id'  => $document_id,
		);

		if ( empty( $document_id ) || empty( $society_id ) ) {
			wp_send_json_error();
		}

		\eoxia\LOG_Util::log( 'DEBUT - Génération du document DUER', 'digirisk' );
		$generation_status = DUER_Class::g()->create_document( $document_id );
		\eoxia\LOG_Util::log( 'FIN - Génération du document DUER', 'digirisk' );

		ZIP_Class::g()->update_temporarly_files_details( array(
			'filename' => $generation_status['document']->data['title'] . '.odt',
			'path'     => $generation_status['document']->data['path'],
		) );

		wp_send_json_success( $response );
	}

	/**
	 * Génères un document de fiche de groupement ou bien de fiche de poste.
	 *
	 * @since 6.5.0
	 */
	public function callback_ajax_generate_establishment() {
		check_ajax_referer( 'generate_establishment' );

		$index       = ! empty( $_POST['index'] ) ? (int) $_POST['index'] : 0; // WPCS: input var ok.
		$element_id  = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0; // WPCS: input var ok.
		$document_id = ! empty( $_POST['duer_document_id'] ) ? (int) $_POST['duer_document_id'] : 0; // WPCS: input var ok.

		$response = array(
			'namespace'         => 'digirisk',
			'module'            => 'DUER',
			'callback_success'  => 'generatedDUERSuccess',
			'index'             => $index,
			'creation_response' => array(),
		);

		$society = Society_Class::g()->show_by_type( $element_id );

		if ( Group_Class::g()->get_type() === $society->data['type'] ) {
			\eoxia\LOG_Util::log( 'DEBUT - Génération du document groupement #GP' . $element_id, 'digirisk' );
			$generation_status = Sheet_Groupment_Class::g()->prepare_document( $society, array(
				'parent' => $society,
			) );
			Sheet_Groupment_Class::g()->create_document( $generation_status['document']->data['id'] );
			\eoxia\LOG_Util::log( 'FIN - Génération du document groupement', 'digirisk' );
		} elseif ( Workunit_Class::g()->get_type() === $society->data['type'] ) {
			\eoxia\LOG_Util::log( 'DEBUT - Génération du document fiche de poste #UT' . $element_id, 'digirisk' );
			$generation_status = Sheet_Workunit_Class::g()->prepare_document( $society, array(
				'parent' => $society,
			) );
			Sheet_Workunit_Class::g()->create_document( $generation_status['document']->data['id'] );
			\eoxia\LOG_Util::log( 'FIN - Génération du document fiche de poste', 'digirisk' );
		}

		ZIP_Class::g()->update_temporarly_files_details( array(
			'filename' => $generation_status['document']->data['title'] . '.odt',
			'path'     => $generation_status['document']->data['path'],
		) );

		$response['duer_document_id'] = $document_id;

		wp_send_json_success( $response );
	}

	/**
	 * Génères le ZIP de tous les documents du DUER courant.
	 *
	 * @since 6.5.0
	 */
	public function callback_ajax_generate_zip() {
		check_ajax_referer( 'generate_zip' );

		$index       = ! empty( $_POST['index'] ) ? (int) $_POST['index'] : 0; // WPCS: input var ok.
		$element_id  = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0; // WPCS: input var ok.
		$document_id = ! empty( $_POST['duer_document_id'] ) ? (int) $_POST['duer_document_id'] : 0; // WPCS: input var ok.

		$response = array(
			'namespace'         => 'digirisk',
			'module'            => 'DUER',
			'callback_success'  => 'generatedDUERSuccess',
			'index'             => $index,
			'creation_response' => array(),
		);

		$element = Society_Class::g()->get( array(
			'id' => $element_id,
		), true );

		\eoxia\LOG_Util::log( 'DEBUT - Génération du ZIP', 'digirisk' );
		$generate_response = ZIP_Class::g()->generate( $element );
		\eoxia\LOG_Util::log( 'FIN - Génération du ZIP', 'digirisk' );

		$response['end'] = true;

		$duer = DUER_Class::g()->get( array( 'id' => $document_id ), true );
		$duer->data['zip_path'] = $generate_response['zip_path'];
		DUER_Class::g()->update( $duer->data );

		ZIP_Class::g()->clear_temporarly_files_details();

		do_action( 'digi_add_historic', array(
			'parent_id' => $element_id,
			'id'        => $duer->data['id'],
			'content'   => sprintf( __( 'Génération du DUER %s', 'digirisk' ), $duer->data['unique_identifier'] ),
		) );

		wp_send_json_success( $response );
	}
}

new DUER_Action();
