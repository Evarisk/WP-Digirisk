<?php
/**
 * Gestion des filtres relatifs aux registres des AT bénins.
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
 * Registre AT Benin Filter class.
 */
class Registre_AT_Benin_Filter extends Identifier_Filter {

	/**
	 * Constructeur.
	 *
	 * @since 7.0.0
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_registre_at_benin_document_data', array( $this, 'callback_digi_document_data' ), 10, 2 );
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
	public function callback_digi_document_data( $data, $society ) {
		$address = Society_Class::g()->get_address( $society );

		$data['reference']  = Registre_AT_Benin_Class::g()->element_prefix;
		$data['reference'] .= Identifier_Filter::get_last_unique_key( '\digi\Registre_AT_Benin_Class' ) + 1;

		$data['raisonSociale'] = $society->data['title'];
		$data['adresse']       = $address->data['address'] . ' ' . $address->data['additional_address'] . ' ' . $address->data['postcode'] . ' ' . $address->data['town'];
		$data['telephone']     = ! empty( $society->data['contact']['phone'] ) ? end( $society->data['contact']['phone'] ) : '';
		$data['siret']         = $society->data['siret_id'];
		$data['email']         = $society->data['contact']['email'];
		$data['effectif']      = $society->data['number_of_employees'];

		$data = $this->get_accidents( $data );

		return $data;
	}

	/**
	 * Récupères les données des accidents.
	 *
	 * @since 7.0.0
	 *
	 * @param  array $data Les données pour le registre des AT bénins.
	 *
	 * @return array       Les données pour le registre des AT bénins modifié.
	 */
	private function get_accidents( $data ) {
		$accidents = Accident_Class::g()->get( array(
			'posts_per_page' => -1,
			'order'          => 'ASC',
		) );

		$data['accidentDebut'] = array(
			'type'  => 'segment',
			'value' => array(),
		);

		$data['accidentFin'] = array(
			'type'  => 'segment',
			'value' => array(),
		);

		if ( ! empty( $accidents ) ) {
			foreach ( $accidents as $accident ) {
				$comments = get_comments( array(
					'post_id' => $element->data['id'],
				) );

				$comment_content = '';
				if ( ! empty( $comments ) ) {
					foreach ( $comments as $comment ) {
						$comment_content .= $comment->comment_content . '
';
					}
				}
				$data['accidentDebut']['value'][] = array(
					'ref'                       => $element->data['unique_identifier'],
					'dateInscriptionRegistre'   => $element->data['registration_date_in_register']['date_input']['fr_FR']['date'],
					'nomPrenomMatriculeVictime' => ! empty( $element->data['victim_identity']->id ) ? User_Digi_Class::g()->element_prefix . $element->data['victim_identity']->id . ' ' . $element->data['victim_identity']->login : '',
					'dateHeure'                 => $element->data['accident_date']['date_input']['fr_FR']['date_time'],
					'lieu'                      => $element->data['place']->modified_unique_identifier . ' ' . $element->data['place']->title,
					'circonstances'             => $comment_content,
					'siegeLesions'              => $element->data['location_of_lesions'],
				);

				$data['accidentFin']['value'][] = array(
					'ref'                   => $element->data['unique_identifier'],
					'natureLesions'         => $element->data['nature_of_lesions'],
					'nomAdresseTemoins'     => $element->data['name_and_address_of_witnesses'],
					'nomAdresseTiers'       => $element->data['name_and_address_of_third_parties_involved'],
					'signatureDonneurSoins' => $this->get_picture( ! empty( $element->data['associated_document_id']['signature_of_the_caregiver_id'][0] ) ? $element->data['associated_document_id']['signature_of_the_caregiver_id'][0] : 0 ),
					'signatureVictime'      => $this->get_picture( ! empty( $element->data['associated_document_id']['signature_of_the_victim_id'][0] ) ? $element->data['associated_document_id']['signature_of_the_victim_id'][0] : 0 ),
					'observations'          => $element->data['observation'],
				);
			}
		}

		return $data;
	}
}

new Registre_AT_Benin_Filter();