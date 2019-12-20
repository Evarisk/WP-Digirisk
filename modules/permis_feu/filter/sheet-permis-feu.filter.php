<?php
/**
 * Classe gérant les filtres des fiches de groupement.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.4
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Sheet Groupement Filter class.
 */
class Sheet_Permis_Feu_Filter extends Identifier_Filter {

	/**
	 * Ajoutes le filtres
	 *
	 * @since 6.2.4
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'eo_model_sheet-permisfeu_before_post', array( $this, 'before_save_doc' ), 10, 2 );
		add_filter( 'digi_sheet-permisfeu_document_data', array( $this, 'callback_digi_document_data' ), 9, 2 );

		add_filter( 'eoxia_main_header_before', array( $this, 'back_button' ) );
		add_filter( 'eoxia_main_header_title', array( $this, 'change_title' ) );
		add_filter( 'eoxia_main_header_li', array( $this, 'add_new_button' ) );
	}

	/**
	 * Ajoutes le titre du document ainsi que le GUID et le chemin vers celui-ci.
	 *
	 * Cette méthode est appelée avant l'ajout du document en base de donnée.
	 *
	 * @since 7.0.0
	 *
	 * @param  array $data Les données du document.
	 * @param  array $args Les données de la requête.
	 *
	 * @return mixed
	 */
	public function before_save_doc( $data, $args ) {
		$upload_dir = wp_upload_dir();

		$data['title']  = current_time( 'Ymd' );
		$data['title'] .= '_permisfeu_';

		$data[ 'title' ] .= $data[ 'parent' ]->data[ 'unique_identifier' ];

		$data['guid'] = $upload_dir['baseurl'] . '/digirisk/0/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = $upload_dir['basedir'] . '/digirisk/0/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = str_replace( '\\', '/', $data['path'] );

		$data['_wp_attached_file'] = '/digirisk/0/' . sanitize_title( $data['title'] ) . '.odt';
		return $data;
	}

	/**
	 * Ajoutes toutes les données nécessaire pour le registre des AT bénins.
	 *
	 * @since 7.0.0
	 *
	 * @param  array         $data    Les données pour le registre des AT bénins.
	 * @param  Society_Model $society Les données de la société.
	 *
	 * @return array                  Les données pour le registre des AT bénins modifié.
	 */
	public function callback_digi_document_data( $data, $args ) {
		$permis_feu = Permis_Feu_Class::g()->add_information_to_permis_feu( $args['parent'] );
		$prevention = Prevention_Class::g()->get( array( 'id' => $permis_feu->data[ 'prevention_id' ] ), true );
		$prevention = Prevention_Class::g()->add_information_to_prevention( $prevention );

		$data_odt = array();

		if( isset( $args[ 'legal_display' ] ) && ! empty( $args[ 'legal_display' ] ) ){
			$data_legal_display = array(
				'pompier_number'    => $args[ 'legal_display' ]->data[ 'emergency_service' ][ 'pompier' ],
				'police_number'     => $args[ 'legal_display' ]->data[ 'emergency_service' ][ 'police' ],
				'samu_number'       => $args[ 'legal_display' ]->data[ 'emergency_service' ][ 'samu' ],
				'emergency_number'  => $args[ 'legal_display' ]->data[ 'emergency_service' ][ 'emergency' ],
			);
			$data_odt = wp_parse_args( $data_legal_display, $data_odt );
		}

		$data_society = array();
		if( isset( $args[ 'society' ] ) && ! empty( $args[ 'society' ] ) ){
			$moyen_generaux = $args[ 'society' ]->data[ 'moyen_generaux' ] != "" ? $args[ 'society' ]->data[ 'moyen_generaux' ] : esc_html__( 'Vide', 'digirisk' );
			$consigne_generale = $args[ 'society' ]->data[ 'consigne_generale' ] != "" ? $args[ 'society' ]->data[ 'consigne_generale' ] : esc_html__( 'Vide', 'digirisk' );

			$data_society = array(
				'moyen_generaux_mis_disposition' => $moyen_generaux,
				'consigne_generale'              => $consigne_generale
			);
		}

		$s_o = $prevention->data[ 'society_outside' ];
		$data_society[ 'society_title' ] =  $s_o[ 'name' ];
		$data_society[ 'society_siret_id' ] = $s_o[ 'siret' ];
		$data_society[ 'society_address' ] =  $s_o[ 'address' ];
		$data_society[ 'society_postcode' ] = $s_o[ 'postal' ];
		$data_society[ 'society_town' ] = $s_o[ 'town' ];


		$return = Permis_Feu_Class::g()->prepare_permis_feu_to_odt_intervention( $permis_feu );

		$data_interventions = $return[ 'data' ];
		$interventions_info = $return[ 'text' ];

		$return_pre = Prevention_Class::g()->prepare_prevention_to_odt_intervention( $prevention );

		$data_interventions_pre = $return_pre[ 'data' ];
		$interventions_info_pre = $return_pre[ 'text' ];

		if( empty( $permis_feu->data[ 'intervenants' ] ) ){
			$permis_feu->data[ 'intervenants' ][0] = array(
				'id' => 0,
				'name' => ' - ',
				'lastname' => ' - ',
				'phone' => ' - ',
				'mail' => esc_html__( 'Aucun intervenant', 'digirisk' )
			);
			$nbr = 0;
		}else{
			$nbr = count( $permis_feu->data[ 'intervenants' ] );
			$intervenants = Prevention_Class::g()->verify_all_intervenant( $permis_feu->data[ 'intervenants' ] );
			$permis_feu->data[ 'intervenants' ] = $intervenants;
		}
		$intervenants_info = esc_html__( sprintf( '%1$d intervenant(s)', $nbr ), 'digirisk' );

		$inter_e = $permis_feu->data[ 'intervenant_exterieur' ];
		$maitre_e = $permis_feu->data[ 'maitre_oeuvre' ];
		if( $maitre_e[ 'data' ]->phone == "" ){
			$maitre_e[ 'data' ]->phone = $permis_feu->data[ 'maitre_oeuvre' ][ 'phone' ];
		}

		$date_end = "";
		if( $permis_feu->data[ 'date_end__is_define' ] == "defined" ){
			$date_end = date( 'd/m/Y', strtotime( $permis_feu->data[ 'date_end' ][ 'rendered' ][ 'mysql' ] ) );
		}else{
			$date_end = esc_html__( 'En cours', 'digirisk' );
		}


		$prevention_args = Permis_Feu_Class::g()->prepare_permis_feu_to_odt_prevention( $prevention );
		$data_odt = wp_parse_args( $prevention_args, $data_odt );

		$maitre_oeuvre_signature_id         = (int) get_post_meta( $permis_feu->data['id'], 'maitre_oeuvre_signature_id', true );
		$intervenant_exterieur_signature_id = (int) get_post_meta( $permis_feu->data['id'], 'intervenant_exterieur_signature_id', true );

		$data = array(
			'id' => $permis_feu->data['id'],
			'unique_identifier' => $permis_feu->data['unique_identifier'],
			'titre_permis_feu' => $permis_feu->data['title'], // 'dateDebutPrevention',
			'date_start_intervention_PPP' => date( 'd/m/Y', strtotime( $permis_feu->data[ 'date_start' ][ 'rendered' ][ 'mysql' ] ) ),
			'date_end_intervention_PPP' => $date_end,
			'intervenants' => array(
				'type'  => 'segment',
				'value' => $permis_feu->data[ 'intervenants' ],
			),
			'intervenants_info' => $intervenants_info,
			'interventions' => array(
				'type'  => 'segment',
				'value' => $data_interventions,
			),
			'interventions_info' => $interventions_info,
			'interventions_pre' => array(
				'type'  => 'segment',
				'value' => $data_interventions_pre,
			),
			'interventions_pre_info' => $interventions_info_pre,
			'maitre_oeuvre_fname' => $maitre_e[ 'data' ]->first_name,
			'maitre_oeuvre_lname' => $maitre_e[ 'data' ]->last_name,
			'maitre_oeuvre_phone' => $maitre_e[ 'data' ]->phone,
			'maitre_oeuvre_email' => $maitre_e[ 'data' ]->user_email,
			'maitre_oeuvre_signature_id' => $maitre_oeuvre_signature_id,
			'maitre_oeuvre_signature_date' => date( 'd/m/Y', strtotime( $maitre_e[ 'signature_date' ][ 'rendered' ][ 'mysql' ] ) ),
			'maitre_oeuvre_signature' => $this->set_picture( $maitre_oeuvre_signature_id, 5 ),
			'intervenant_exterieur_fname' => $inter_e[ 'firstname' ],
			'intervenant_exterieur_lname' => $inter_e[ 'lastname' ],
			'intervenant_exterieur_phone' => $inter_e[ 'phone' ],
			'intervenant_exterieur_email' => $inter_e[ 'email' ],
			'intervenant_exterieur_signature' => $this->set_picture( $intervenant_exterieur_signature_id, 5 ),
			'intervenant_exterieur_signature_id' => (int) get_post_meta( $permis_feu->data['id'], 'intervenant_exterieur_signature_id', true ),
			'intervenant_exterieur_signature_date' => date( 'd/m/Y', strtotime( $inter_e[ 'signature_date' ][ 'rendered' ][ 'mysql' ] ) ),
		);

		$data_odt = wp_parse_args( $data_society, $data_odt );
		$data_odt = wp_parse_args( $data, $data_odt );

		return $data_odt;
	}

	public function set_picture( $id, $size = 9 ) {
		$id = intval( $id );
		$picture = '';

		if ( ! empty( $id ) ) {
			$picture_definition = wp_get_attachment_image_src( $id, 'medium' );
			$picture_path       = str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] );

			if ( is_file( $picture_path ) ) {
				$picture = array(
					'type'   => 'picture',
					'value'  => str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] ),
					'option' => array(
						'size' => $size,
					),
				);
			}
		}

		return $picture;
	}

	public function back_button( $content ) {
		if ( 'digirisk-permis-feu' === $_REQUEST['page'] && isset( $_GET['id'] ) ) {
			ob_start();
			\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/back-icon' );
			$content .= ob_get_clean();
		}
		return $content;
	}

	public function change_title( $content ) {
		if ( 'digirisk-permis-feu' === $_REQUEST['page'] && isset( $_GET['id'] ) ) {
			$prevention = Permis_Feu_Class::g()->get( array( 'id' => $_GET['id'] ), true );

			if ( $prevention->data[ 'is_end' ] ) {
				$content = __( sprintf( 'Permis de feu en modification #%s', (int) $_GET['id'] ), 'digirisk' );
			} else {
				$content = __( sprintf( 'Permis de feu en cours #%s', (int) $_GET['id'] ), 'digirisk' );

			}
		}
		return $content;
	}

	public function add_new_button( $content ) {
		if ( 'digirisk-permis-feu' === $_REQUEST['page'] && ! isset( $_GET['id'] ) ) {
			ob_start();
			\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'new-button' );
			$content .= ob_get_clean();
		}

		return $content;
	}

}

new Sheet_Permis_Feu_Filter();
