<?php
/**
 * Cette classe sert seulement au indicator dans la partie configuration de Digirisk
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2019 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     7.3.5
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Legal Display Indicator Class.
 */
class Legal_Display_Indicator_Class extends Document_Class {

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_legal_display_indicator';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '1.0';


	/**
	 * Initialises les messages d'information pour la génération de l'ODT.
	 */
	protected function construct() {}


	/**
	 * Cette classe devrait etre adapté selon l'évolution des données dans la page de configuration
	 * @return [type] [description]
	 */
	public function generate_data_indicator( $element, $address, $legal_display, $diffusion_information ){
		$data_nbr = array(
			'nbr_total' => 0,
			'nbr_valid' => 0,
			'percent'   => 0,
			'info'      => ''
		);

		$data = array(
			'society' => $this->generate_data_indicator_society( $element, $address, $data_nbr ),
			'society-more' => $this->generate_data_indicator_society_more( $element, $address, $data_nbr ),
			'detective-work' => $this->generate_data_indicator_dectective_work( $legal_display, $data_nbr ),
			'health-service' => $this->generate_data_indicator_health_service( $legal_display, $data_nbr ),
			'emergency-service' => $this->generate_data_indicator_emergency_service( $legal_display, $data_nbr ),
			'working-hours' => $this->generate_data_indicator_working_hours( $legal_display, $data_nbr ),
			'others-informations' => $this->generate_data_indicator_others_informations( $legal_display, $data_nbr ),
			'staff-representatives' => $this->generate_data_indicator_staff( $diffusion_information, $data_nbr ),
		);
		$element->data[ 'indicator' ] = $data;

		return $element;
	}

	public function check_if_var_is_valid( $data, $element, $is_default_value = false, $value_default = 0 ){
		$data[ 'nbr_total' ] ++;
		if( $element != "" ){
			if( ! $is_default_value || $element != $value_default  ){
				$data[ 'nbr_valid' ] ++;
			}
		}
		return $data;
	}


	public function generate_data_indicator_staff( $diffusion_information, $data ){
		$diff_i_d = $diffusion_information->data;

		$data = $this->check_if_var_is_valid( $data, $diff_i_d['delegues_du_personnels_date']['raw'] );
		$data = $this->check_if_var_is_valid( $data, $diff_i_d['delegues_du_personnels_titulaires'] );
		$data = $this->check_if_var_is_valid( $data, $diff_i_d['delegues_du_personnels_suppleants'] );

		$data = $this->check_if_var_is_valid( $data, $diff_i_d['delegues_du_personnels_suppleants'] );
		$data = $this->check_if_var_is_valid( $data, $diff_i_d['membres_du_comite_entreprise_titulaires'] );
		$data = $this->check_if_var_is_valid( $data, $diff_i_d['membres_du_comite_entreprise_suppleants'] );
		return $this->calcul_percent_indicator( $data );
	}

	public function generate_data_indicator_others_informations( $legal_display, $data ){
		$legal_display_d_ca = $legal_display->data['collective_agreement'];

		$data = $this->check_if_var_is_valid( $data, $legal_display_d_ca['title_of_the_applicable_collective_agreement'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d_ca['location_and_access_terms_of_the_agreement'] );

		$data = $this->check_if_var_is_valid( $data, $legal_display->data['rules']['location'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display->data['DUER']['how_access_to_duer'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display->data['participation_agreement']['information_procedures'] );

		return $this->calcul_percent_indicator( $data );
	}

	public function generate_data_indicator_working_hours( $legal_display, $data ){
		$legal_display_d_dr = $legal_display->data['derogation_schedule'];

		$data = $this->check_if_var_is_valid( $data, $legal_display_d_dr['permanent'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d_dr['occasional'] );

		return $this->calcul_percent_indicator( $data );
	}

	public function generate_data_indicator_emergency_service( $legal_display, $data ){
		$legal_display_d_es = $legal_display->data['emergency_service'];
		$legal_display_d_sr = $legal_display->data['safety_rule'];

		$data = $this->check_if_var_is_valid( $data, $legal_display_d_es['samu'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d_es['police'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d_es['pompier'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d_es['emergency'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d_es['right_defender'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d_es['poison_control_center'] );

		$data = $this->check_if_var_is_valid( $data, $legal_display_d_sr['responsible_for_preventing'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d_sr['phone'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d_sr['location_of_detailed_instruction']);

		return $this->calcul_percent_indicator( $data );
	}

	public function generate_data_indicator_health_service( $legal_display, $data ){
		$legal_display_d = $legal_display->data['occupational_health_service'];

		$data = $this->check_if_var_is_valid( $data, $legal_display_d->data['full_name'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d->data['address']->data['address'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d->data['address']->data['postcode'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d->data['address']->data['town'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d->data['contact']['phone'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d->data['opening_time'] );

		return $this->calcul_percent_indicator( $data );
	}

	public function generate_data_indicator_dectective_work( $legal_display, $data ){
		$legal_display_d = $legal_display->data['detective_work'];

		$data = $this->check_if_var_is_valid( $data, $legal_display_d->data['full_name'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d->data['address']->data['address'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d->data['address']->data['postcode'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d->data['address']->data['town'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d->data['contact']['phone'] );
		$data = $this->check_if_var_is_valid( $data, $legal_display_d->data['opening_time'] );

		return $this->calcul_percent_indicator( $data );
	}


	public function generate_data_indicator_society_more( $element, $address, $data ){

		$data = $this->check_if_var_is_valid( $data, $element->data['contact']['phone'] );
		$data = $this->check_if_var_is_valid( $data, $element->data['contact']['email'] );
		$data = $this->check_if_var_is_valid( $data, $element->data['content'] );
		$data = $this->check_if_var_is_valid( $data, $element->data['moyen_generaux'] );
		$data = $this->check_if_var_is_valid( $data, $element->data['consigne_generale'] );

		return $this->calcul_percent_indicator( $data );
	}

	public function generate_data_indicator_society( $element, $address, $data ){

		$data = $this->check_if_var_is_valid( $data, $element->data['title'] );
		$data = $this->check_if_var_is_valid( $data, $element->data['siret_id'] );
		$data = $this->check_if_var_is_valid( $data, $element->data['number_of_employees'], true, '0' );
		$data = $this->check_if_var_is_valid( $data, $element->data['owner_id'], true, '-1' );

		$data = $this->check_if_var_is_valid( $data, $element->data['date']['raw'] );
		 // Date de création de l'entreprise => Valide par défaut

		if( ! empty( $address ) ){
		 	$data = $this->check_if_var_is_valid( $data, $address->data['address'] );
		 	$data = $this->check_if_var_is_valid( $data, $address->data['additional_address'] );
		 	$data = $this->check_if_var_is_valid( $data, $address->data['postcode'] );
		 	$data = $this->check_if_var_is_valid( $data, $address->data['town'] );
		}

		return $this->calcul_percent_indicator( $data );
	}

	public function calcul_percent_indicator( $data ){
		if( $data[ 'nbr_total' ] <= 0 ){
			$value = 100;
		}else if( $data[ 'nbr_valid' ] <= 0 ){
			$value = 0;
		}else{
			$value = ( $data[ 'nbr_valid' ] / $data[ 'nbr_total' ] ) * 100;
			$value = round( $value, 1 );
		}
		$data[ 'percent' ] = round( $value, 0 );
		$data[ 'info' ] = $data[ 'nbr_valid' ] . '/' . $data[ 'nbr_total' ] . ' (' . $data[ 'percent' ] . '%)';
		return $data;
	}
}

Legal_Display_Indicator_Class::g();
