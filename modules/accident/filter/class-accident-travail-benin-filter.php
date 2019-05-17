<?php
/**
 * Gestion des filtres relatifs aux documents des AT bénins.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * AT Benin Filter class.
 */
class Accident_Travail_Benin_Filter extends Identifier_Filter {

	/**
	 * Constructeur.
	 *
	 * @since 7.0.0
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_accident_benin_document_data', array( $this, 'callback_digi_document_data' ), 10, 2 );
	}

	/**
	 * Ajoutes toutes les données nécessaire pour le registre des AT bénins.
	 *
	 * @since 7.0.0
	 *
	 * @param  array          $data    Les données pour l'ODT de l'accident.
	 * @param  Accident_Model $accident Les données de l'accident.
	 *
	 * @return array                  Les données pour l'ODT de l'accident modifié.
	 */
	public function callback_digi_document_data( $data, $args ) {
		$main_society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );
		$accident = $args['parent'];

		$address = Society_Class::g()->get_address( $main_society );

		$comments = get_comments( array(
			'post_id' => $accident->data['id'],
		) );

		$comment_content = '';
		if ( ! empty( $comments ) ) {
			foreach ( $comments as $comment ) {
				$comment_content .= $comment->comment_content . '
';
			}
		}

		$data = array(
			'raisonSociale'             => $main_society->data['title'],
			'adresse'                   => $address->data['address'] . ' ' . $address->data['additional_address'] . ' ' . $address->data['postcode'] . ' ' . $address->data['town'],
			'telephone'                 => ! empty( $main_society->data['contact']['phone'] ) ? max( $main_society->data['contact']['phone'] ) : '',
			'siret'                     => $main_society->data['siret_id'],
			'email'                     => $main_society->data['contact']['email'],
			'effectif'                  => $main_society->data['number_of_employees'],
			'ref'                       => $accident->data['unique_identifier'],
			'dateInscriptionRegistre'   => $accident->data['registration_date_in_register']['rendered']['date'],
			'nomPrenomMatriculeVictime' => ! empty( $accident->data['victim_identity']->data['id'] ) ? User_Class::g()->element_prefix . $accident->data['victim_identity']->data['id'] . ' ' . $accident->data['victim_identity']->data['login'] : '',
			'dateHeure'                 => $accident->data['accident_date']['rendered']['date_time'],
			'lieu'                      => $accident->data['place']->data['unique_identifier'] . ' ' . $accident->data['place']->data['title'],
			'circonstances'             => $comment_content,
			'siegeLesions'              => $accident->data['location_of_lesions'],
			'natureLesions'             => $accident->data['nature_of_lesions'],
			'nomAdresseTemoins'         => $accident->data['name_and_address_of_witnesses'],
			'nomAdresseTiers'           => $accident->data['name_and_address_of_third_parties_involved'],
			'signatureDonneurSoins'     => ! empty( $accident->data['associated_document_id']['signature_of_the_caregiver_id'][0] ) ? Document_Util_Class::g()->get_picture( $accident->data['associated_document_id']['signature_of_the_caregiver_id'][0], 6, 'full' ) : array(),
			'signatureVictime'          => ! empty( $accident->data['associated_document_id']['signature_of_the_victim_id'][0] ) ? Document_Util_Class::g()->get_picture(  $accident->data['associated_document_id']['signature_of_the_victim_id'][0], 6, 'full' ) : array(),
			'observations'              => $accident->data['observation'],
			'enqueteAccident'           => $accident->data['have_investigation'] ? __( 'Yes', 'digirisk' ) : __( 'No', 'digirisk' ),
		);

		return $data;
	}
}

new Accident_Travail_Benin_Filter();
