<?php
/**
 * Appelle la vue pour afficher le formulaire de configuration d'une société
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Appelle la vue pour afficher le formulaire de configuration d'une société
 */
class Society_Informations_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @return void
	 */
	protected function construct() {}

	/**
	 * Charges le responsable et l'addresse du groupement.
	 * Envois les données à la vue group/configuration-form.view.php
	 *
	 * @param  Group_Model $element L'objet groupement.
	 * @return void
	 *
	 * @since 6.2.10
	 * @version 6.2.10
	 */
	public function display( $element ) {
		$address = Society_Class::g()->get_address( $element );
		$address = $address[0];

		$total_cotation = 0;

		$risks = Risk_Class::g()->get( array(
			'post_parent' => $element->id,
		) );

		$historic_update = get_post_meta( $element->id, \eoxia\Config_Util::$init['digirisk']->historic->key_historic, true );

		if ( empty( $historic_update ) ) {
			$historic_update = array(
				'date' => 'Indisponible',
				'content' => 'Indisponible',
			);
		} else {
			$historic_update['date'] = date( '\L\e d F Y à H\hi', strtotime( $historic_update['date'] ) );
		}

		if ( count( $risks ) > 1 ) {
			usort( $risks, function( $a, $b ) {
				if ( $a->evaluation->risk_level['equivalence'] === $b->evaluation->risk_level['equivalence'] ) {
					return 0;
				}
				return ( $a->evaluation->risk_level['equivalence'] > $b->evaluation->risk_level['equivalence'] ) ? -1 : 1;
			} );
		}

		if ( ! empty( $risks ) ) {
			foreach ( $risks as $risk ) {
				$total_cotation += $risk->evaluation->risk_level['equivalence'];
			}
		}

		\eoxia\View_Util::exec( 'digirisk', 'society', 'informations/main', array(
			'element'             => $element,
			'address'             => $address,
			'number_risks'        => count( $risks ),
			'more_dangerous_risk' => ! empty( $risks[0] ) ? $risks[0] : null,
			'total_cotation'      => $total_cotation,
			'historic_update'     => $historic_update,
		) );
	}

	/**
	 * Sauvegardes les données du groupements
	 *
	 * @since 6.2.10
	 * @version 6.4.0
	 *
	 * @param  array $data  Les données à sauvegarder.
	 * @return Society_Model Le groupement mis à jour.
	 */
	public function save( $data ) {
		$society = Society_Class::g()->get( array(
			'id'        => $data['id'],
			'post_type' => array( 'digi-society', 'digi-group', 'digi-workunit' ),
		), true );

		$society->title                   = $data['title'];
		$society->owner_id                = $data['owner_id'];
		$society->date                    = $data['date'];
		$society->siret_id                = ! empty( $data['siret_id'] ) ? $data['siret_id'] : '';
		$society->number_of_employees     = ! empty( $data['number_of_employees'] ) ? $data['number_of_employees'] : 0;
		$society->contact['phone'][]      = $data['contact']['phone'][0];
		$society->contact['email']        = $data['contact']['email'];
		$society->contact['address_id'][] = $data['contact']['address_id'][0];
		$society->content                 = $data['content'];

		$society = Society_Class::g()->update( $society );
		return $society;
	}
}

Society_Informations_Class::g();
