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
class Sheet_Prevention_Filter extends Identifier_Filter {

	/**
	 * Ajoutes le filtres
	 *
	 * @since 6.2.4
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'eo_model_sheet-prevention_before_post', array( $this, 'before_save_doc' ), 10, 2 );
		add_filter( 'digi_sheet-prevention_document_data', array( $this, 'callback_digi_document_data' ), 9, 2 );
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

		$data['title']  = current_time( 'Ymd' ) . '_';
		$data['title'] .= '_fiche_prevention_';

		$data[ 'title' ] .= $data['parent']->data['id'];

		// $data['title'] .= $data['parent']->data['unique_identifier'];
		$data['title']  = str_replace( '-', '_', $data['title'] );

		$data['guid'] = $upload_dir['baseurl'] . '/digirisk/0/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = $upload_dir['basedir'] . '/digirisk/0/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = str_replace( '\\', '/', $data['path'] );

		$data['_wp_attached_file'] = '/digirisk/0/' . sanitize_title( $data['title'] ) . '.odt';
		return $data;
	}

	/**
	 * [public description]
	 * @var [type]
	 */
	public function callback_digi_document_identifier_prevention( $unique_identifier, $prevention ) {
		$unique_identifier = $prevention->unique_identifier . '_' . $prevention->second_identifier . '_';
		return $unique_identifier;
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
		$prevention = $args['parent'];
		$prevention = Prevention_Class::g()->add_information_to_prevention( $prevention );

		if( isset( $args[ 'legal_display' ] ) && ! empty( $args[ 'legal_display' ] ) ){
			$data_legal_display = array(
				'pompier_number'    => $args[ 'legal_display' ]->data[ 'emergency_service' ][ 'pompier' ],
				'police_number'     => $args[ 'legal_display' ]->data[ 'emergency_service' ][ 'police' ],
				'samu_number'       => $args[ 'legal_display' ]->data[ 'emergency_service' ][ 'samu' ],
				'emergency_number'  => $args[ 'legal_display' ]->data[ 'emergency_service' ][ 'emergency' ],
				'responsible_name'  => $args[ 'legal_display' ]->data[ 'safety_rule' ][ 'responsible_for_preventing' ],
				'responsible_phone' => $args[ 'legal_display' ]->data[ 'safety_rule' ][ 'phone' ]
			);
		}

		if( isset( $args[ 'society' ] ) && ! empty( $args[ 'society' ] ) ){
			$data_society = array(
				'society_title'    => $args[ 'society' ]->data[ 'title' ],
				'society_siret_id' => $args[ 'society' ]->data[ 'siret_id' ] != "" ? $args[ 'society' ]->data[ 'siret_id' ] : ''
			);
		}

		$data_interventions = array();

		if( $prevention->data[ 'intervention' ] ){
			foreach( $prevention->data[ 'intervention' ] as $intervention ){
				$risk = Risk_Category_Class::g()->get( array( 'id' => $intervention->data[ 'risk' ] ), true );
				$data_temp = array(
					'key_unique'    => $intervention->data[ 'key_unique' ],
					'unite_travail' => Prevention_Intervention_Class::g()->return_name_workunit( $intervention->data[ 'unite_travail' ] ),
					'action'        => $intervention->data[ 'action_realise' ],
					'risk'          => $risk->data[ 'name' ],
					'prevention'    => $intervention->data[ 'moyen_prevention' ]
				);
				$data_interventions[] = $data_temp;
			}
		}

		$inter_e = $prevention->data[ 'intervenant_exterieur' ];
		$maitre_e = $prevention->data[ 'maitre_oeuvre' ];
		$data = array(
			'id' => $prevention->data['id'],
			'titrePrevention' => $prevention->data['title'], // 'dateDebutPrevention',
			'date_start_intervention_PPP' => date( 'd/m/Y', strtotime( $prevention->data[ 'date_start' ][ 'rendered' ][ 'mysql' ] ) ),
			'date_end_intervention_PPP' => date( 'd/m/Y', strtotime( $prevention->data[ 'date_closure' ][ 'rendered' ][ 'mysql' ] ) ),
			'intervenants' => array(
				'type'  => 'segment',
				'value' => $prevention->data[ 'intervenants' ],
			),
			'interventions' => array(
				'type'  => 'segment',
				'value' => $data_interventions,
			),
			'maitre_oeuvre_fname' => $maitre_e[ 'data' ]->first_name,
			'maitre_oeuvre_lname' => $maitre_e[ 'data' ]->last_name,
			'maitre_oeuvre_phone' => $maitre_e[ 'data' ]->phone,
			'maitre_oeuvre_signature_id' => $maitre_e[ 'signature_id' ],
			'maitre_oeuvre_signature_date' => date( 'd/m/Y', strtotime( $maitre_e[ 'signature_date' ][ 'rendered' ][ 'mysql' ] ) ),
			'maitre_oeuvre_signature' => $this->set_picture( $maitre_e[ 'signature_id' ], 5 ),
			'intervenant_exterieur_fname' => $inter_e[ 'firstname' ],
			'intervenant_exterieur_lname' => $inter_e[ 'lastname' ],
			'intervenant_exterieur_phone' => $inter_e[ 'phone' ],
			'intervenant_exterieur_signature' => $this->set_picture( $inter_e[ 'signature_id' ], 5 ),
			'intervenant_exterieur_signature_id' => $inter_e[ 'signature_id' ],
			'intervenant_exterieur_signature_date' => date( 'd/m/Y', strtotime( $inter_e[ 'signature_date' ][ 'rendered' ][ 'mysql' ] ) ),
		);

		$data = wp_parse_args( $data_legal_display, $data );
		$data = wp_parse_args( $data_society, $data );

		return $data;
	}

	public function set_picture( $id, $size = 9 ) {
		$id = intval( $id );
		$picture = __( 'No picture defined', 'digirisk' );

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
}

new Sheet_Prevention_Filter();
