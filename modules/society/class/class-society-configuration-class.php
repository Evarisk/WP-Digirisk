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
class Society_Configuration_Class extends \eoxia\Singleton_Util {

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

		$legal_display = Legal_Display_Class::g()->get_legal_display( $element->data[ 'id' ] );
		$diffusion_information = Legal_Display_Class::g()->get_diffusion_information( $element->data[ 'id' ] );

		$eo_search->register_search( 'society_information_owner', array(
			'label'        => 'Responsable',
			'icon'         => 'fa-search',
			'type'         => 'user',
			'name'         => 'society[owner_id]',
			'value'        => ! empty( $element->data['owner']->data['id'] ) ? User_Class::g()->element_prefix . $element->data['owner']->data['id'] . ' - ' . $element->data['owner']->data['displayname'] : '',
			'hidden_value' => $element->data['owner_id'],
		) );

		\eoxia\View_Util::exec( 'digirisk', 'society', 'dashboard/main', array(
			'element' => $element,
			'address' => $address,
			'legal_display' => $legal_display,
			'diffusion_information' => $diffusion_information
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
	public function save( $data_form ) { // 25/09/2019 Faudrait changer tout ça - Corentin
		$society = Society_Class::g()->show_by_type( $data_form['id'] );

		$society->data['title']               = ! empty( $data_form['title'] ) ? sanitize_text_field( $data_form['title'] ) : '';
		$society->data['owner_id']            = ! empty( $data_form['owner_id'] ) ? (int) $data_form['owner_id'] : 0;
		$society->data['date']                = ! empty( $data_form['date'] ) ? sanitize_text_field( $data_form['date'] ) : '';
		$society->data['siret_id']            = ! empty( $data_form['siret_id'] ) ? sanitize_text_field( $data_form['siret_id'] ) : '';
		$society->data['number_of_employees'] = ! empty( $data_form['number_of_employees'] ) ? (int) $data_form['number_of_employees'] : 0;
		$society->data['contact']['email']    = ! empty( $data_form['contact']['email'] ) ? sanitize_text_field( $data_form['contact']['email'] ) : '';
		$society->data['content']             = ! empty( $data_form['content'] ) ? $data_form['content'] : '';
		$society->data['moyen_generaux']      = ! empty( $data_form['moyen_generaux'] ) ? $data_form['moyen_generaux'] : '';
		$society->data['consigne_generale']   = ! empty( $data_form['consigne_generale'] ) ? $data_form['consigne_generale'] : '';

		$phone      = ! empty( $data_form['contact']['phone'] ) ? sanitize_text_field( $data_form['contact']['phone'] ) : '';
		$address_id = ! empty( $data_form['contact']['address_id'] ) ? (int) $data_form['contact']['address_id'] : 0;

		if ( ! empty( $phone ) ) {
			$society->data['contact']['phone'][] = $phone;
		}

		if ( ! empty( $address_id ) ) {
			$society->data['contact']['address_id'][] = $address_id;
		}

		switch ( $society->data['type'] ) {
			case 'digi-society':
				$society = Society_Class::g()->update( $society->data );
				break;
			case 'digi-group':
				$society = Group_Class::g()->update( $society->data );
				break;
			case 'digi-workunit':
				$society = Workunit_Class::g()->update( $society->data );
				break;
		}

		return $society;
	}

	public function display_form_owner( $element ){
		global $eo_search;

		$user_info = get_user_by( 'id', $element->data[ 'owner_id' ] );

		$eo_search->register_search( 'society_information_owner', array(
			'label'        => 'Responsable',
			'icon'         => 'fa-search',
			'type'         => 'user',
			'name'         => 'society[owner_id]',
			'value'        => ! empty( $user_info->data->ID ) ? User_Class::g()->element_prefix . $user_info->data->ID . ' - ' . $user_info->data->display_name : '',
			'hidden_value' => ! empty( $user_info->data->ID ) ? $user_info->data->ID : -1,
		) );

		\eoxia\View_Util::exec( 'digirisk', 'society', 'informations/configuration-form-owner', array(
			'element' => $element,
		) );
	}
}

Society_Configuration_Class::g();
