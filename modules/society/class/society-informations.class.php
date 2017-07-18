<?php
/**
 * Appelle la vue pour afficher le formulaire de configuration d'une société
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.10.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

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
	 * @since 6.2.10.0
	 * @version 6.2.10.0
	 */
	public function display( $element ) {
		$address = Society_Class::g()->get_address( $element );
		$address = $address[0];

		$owner_user = $this->get_owner_user( $element );

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
			'element' => $element,
			'owner_user' => $owner_user,
			'address' => $address,
			'number_risks' => count( $risks ),
			'more_dangerous_risk' => ! empty( $risks[0] ) ? $risks[0] : null,
			'total_cotation' => $total_cotation,
			'historic_update' => $historic_update,
		) );
	}

	/**
	 * Récupères le responsable du groupement
	 *
	 * @param  Group_Model $groupment L'objet groupement.
	 * @return User_Digi_Model				Le responsable du groupement
	 */
	public function get_owner_user( $groupment ) {
		$args_owner_user = array( 'schema' => true );

		if ( ! empty( $groupment->user_info['owner_id'] ) ) {
			$args_owner_user = array( 'include' => array( $groupment->user_info['owner_id'] ) );
		}

		$owner_user = User_Digi_Class::g()->get( $args_owner_user );

		return $owner_user[0];
	}

	/**
	 * Sauvegardes les données du groupements
	 *
	 * @param  array $data  Les données à sauvegarder.
	 * @return Group_Model Le groupement mis à jour.
	 */
	public function save( $data ) {
		$society = society_class::g()->show_by_type( $data['id'] );

		$society->title = $data['title'];
		$society->user_info['owner_id'] = $data['user_info']['owner_id'];
		$society->date = $data['date'];
		$society->contact['phone'][] = $data['contact']['phone'][0];
		$society->contact['address_id'][] = $data['contact']['address_id'][0];
		$society->content = $data['content'];

		$society = Society_Class::g()->update_by_type( $society );
		return $society;
	}
}

Society_Informations_Class::g();
