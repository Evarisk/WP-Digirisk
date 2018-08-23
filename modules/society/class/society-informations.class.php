<?php
/**
 * Appelle la vue pour afficher le formulaire de configuration d'une société
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @copyright 2015-2018 Evarisk
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
	 */
	protected function construct() {}

	/**
	 * Charges le responsable et l'addresse du groupement.
	 * Envois les données à la vue group/configuration-form.view.php
	 *
	 * @param  Group_Model $element L'objet groupement.
	 *
	 * @since 6.2.10
	 */
	public function display( $element ) {
		global $eo_search;

		$address = Society_Class::g()->get_address( $element );

		$total_cotation = 0;

		$risks = Risk_Class::g()->get( array(
			'post_parent' => $element->data['id'],
		) );

		$historic_update = get_post_meta( $element->data['id'], \eoxia\Config_Util::$init['digirisk']->historic->key_historic, true );

		if ( empty( $historic_update ) ) {
			$historic_update = array(
				'date'    => 'Indisponible',
				'content' => 'Indisponible',
			);
		} else {
			$historic_update['date'] = date( ' d F Y à H\hi', strtotime( $historic_update['date'] ) );
		}

		if ( count( $risks ) > 1 ) {
			usort( $risks, function( $a, $b ) {
				if ( $a->data['evaluation']->data['current_equivalence'] === $b->data['evaluation']->data['current_equivalence'] ) {
					return 0;
				}
				return ( $a->data['evaluation']->data['current_equivalence'] > $b->data['evaluation']->data['current_equivalence'] ) ? -1 : 1;
			} );
		}

		if ( ! empty( $risks ) ) {
			foreach ( $risks as $risk ) {
				$total_cotation += $risk->data['evaluation']->data['current_equivalence'];
			}
		}

		$eo_search->register_search( 'society_information_owner', array(
			'label'        => 'Responsable',
			'icon'         => 'fa-search',
			'type'         => 'user',
			'name'         => 'society[owner_id]',
			'value'        => ! empty( $element->data['owner']->data['id'] ) ? User_Digi_Class::g()->element_prefix . $element->data['owner']->data['id'] . ' - ' . $element->data['owner']->data['displayname'] : '',
			'hidden_value' => $element->data['owner_id'],
		) );

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
	 * @version 6.5.0
	 *
	 * @param  array $data_form  Les données à sauvegarder.
	 * @return Society_Model     Le groupement mis à jour.
	 */
	public function save( $data_form ) {
		$data = array();

		$data['id']                  = ! empty( $data_form['id'] ) ? (int) $data_form['id'] : 0;
		$data['type']                = ! empty( $data_form['type'] ) ? sanitize_text_field( $data_form['type'] ) : '';
		$data['title']               = ! empty( $data_form['title'] ) ? sanitize_text_field( $data_form['title'] ) : '';
		$data['owner_id']            = ! empty( $data_form['owner_id'] ) ? (int) $data_form['owner_id'] : 0;
		$data['date']                = ! empty( $data_form['date'] ) ? sanitize_text_field( $data_form['date'] ) : '';
		$data['siret_id']            = ! empty( $data_form['siret_id'] ) ? sanitize_text_field( $data_form['siret_id'] ) : '';
		$data['number_of_employees'] = ! empty( $data_form['number_of_employees'] ) ? (int) $data_form['number_of_employees'] : 0;
		$data['contact']['email']    = ! empty( $data_form['contact']['email'] ) ? sanitize_email( $data_form['contact']['email'] ) : '';
		$data['content']             = ! empty( $data_form['content'] ) ? sanitize_text_field( $data_form['content'] ) : '';

		$phone      = ! empty( $data_form['contact']['phone'] ) ? sanitize_text_field( $data_form['contact']['phone'] ) : '';
		$address_id = ! empty( $data_form['contact']['address_id'] ) ? (int) $data_form['contact']['address_id'] : 0;

		$data['$push']['contact'] = array();

		if ( ! empty( $phone ) ) {
			$data['$push']['contact']['phone'] = $phone;
		}

		if ( ! empty( $address_id ) ) {
			$data['$push']['contact']['address_id'] = $address_id;
		}

		$society = Society_Class::g()->update( $data );
		return $society;
	}
}

Society_Informations_Class::g();
