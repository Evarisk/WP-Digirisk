<?php
/**
 * Classe gérant les filtres des accidents.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Filters
 *
 * @since     6.1.5
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Accident Filter class.
 */
class Accident_Filter extends Identifier_Filter {

	/**
	 * Utilises le filtre digi_tab
	 *
	 * @since 6.1.5
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 2, 2 );

		$current_type = Accident_Class::g()->get_type();
		add_filter( "eo_model_{$current_type}_after_get", array( $this, 'get_full_accident' ), 10, 2 );

		add_filter( "eo_model_{$current_type}_after_post", array( $this, 'get_full_accident' ), 10, 2 );
		add_filter( "eo_model_{$current_type}_after_post", array( $this, 'accident_compile_stopping_days' ), 10, 2 );

		add_filter( "eo_model_{$current_type}_after_put", array( $this, 'get_full_accident' ), 10, 2 );
		add_filter( "eo_model_{$current_type}_after_put", array( $this, 'accident_compile_stopping_days' ), 10, 2 );
	}

	/**
	 * Ajoutes l'onglet accident dans les groupements et les unités de travail
	 *
	 * @since 6.1.5
	 *
	 * @param  array   $list_tab Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 *
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-society']['registre-accident'] = array(
			'type'  => 'text',
			'text'  => __( 'Registre des accidents bénins', 'digirisk' ),
			'title' => __( 'Registre des accidents bénins', 'digirisk' ),
			'icon'  => 'AT',
		);

		return $list_tab;
	}

	/**
	 * Récupères tous les éléments nécessaires pour le fonctionnement d'un accident
	 * Risque et commentaire.
	 *
	 * @since 6.3.0
	 *
	 * @param Accident_Model $object L'objet
	 * @param array          $args   Les données lors de la construction de
	 * l'objet.
	 *
	 * @return Accident_Model L'objet avec tous les éléments ajoutés par cette méthode.
	 */
	public function get_full_accident( $object, $args ) {
		$object->data['victim_identity'] = User_Class::g()->get( array( 'schema' => true ), true );

		if ( ! empty( $object->data['risk_id'] ) ) {
			$object->data['risk'] = Risk_Class::g()->get( array( 'id' => $object->data['risk_id'] ), true );
		}

		if ( ! empty( $object->data['victim_identity_id'] ) ) {
			$object->data['victim_identity'] = User_Class::g()->get( array( 'id' => $object->data['victim_identity_id'] ), true );
		}

		if ( ! isset( $object->data['unique_identifier'] ) ) {
			$object->data['unique_identifier'] = '';
		}

		$object->data['document'] = Accident_Travail_Benin_Class::g()->get( array(
			'post_parent'    => $object->data['id'],
			'posts_per_page' => 1,
		), true );

		if ( empty( $object->data['document'] ) ) {
			$object->data['document'] = Accident_Travail_Benin_Class::g()->get( array( 'schema' => true ), true );
		}

		if ( ! empty( $object->data['parent_id'] ) ) {
			$object->data['place'] = Society_Class::g()->show_by_type( $object->data['parent_id'] );
		}

		$object->data['stopping_days'] = Accident_Travail_Stopping_Day_Class::g()->get( array(
			'post_parent' => $object->data['id'],
			'post_status' => 'publish',
		 ) );

		$object->data['number_field_completed'] = $this->accident_calcul_completed_field( $object, array() );

		$object->data['comment'] = Accident_Comment_Class::g()->get( array( 'post_id' => $object->data['id'] ) );

		return $object;
	}

	/**
	 * Compiles le nombre de jour d'arrêt.
	 *
	 * @since 6.4.0
	 *
	 * @param  Accident_Model $object L'objet.
	 *
	 * @return Accident_Model
	 */
	public function accident_compile_stopping_days( $object, $args ) {
		$object->data['compiled_stopping_days'] = 0;

		if ( ! empty( $object->data['stopping_days'] ) ) {
			foreach ( $object->data['stopping_days'] as $stopping_days ) {
				$object->data['compiled_stopping_days'] += (int) $stopping_days->data['content'];
			}
		}

		return $object;
	}

	/**
	 * Calcule le nombre de champ en DUR complété dans les données.
	 *
	 * @since 6.4.0
	 *
	 * @param Accident_Model $data L'objet.
	 *
	 * @return integer       Le nombre de champ complétés.
	 */
	public function accident_calcul_completed_field( $object, $args ) {
		$number_field_completed = 0;

		if ( ! empty( $object->data['victim_identity_id'] ) ) {
			$number_field_completed++;
		}

		if ( ! empty( $object->data['accident_date'] ) ) {
			$number_field_completed++;
		}

		if ( ! empty( $object->data['place'] ) ) {
			$number_field_completed++;
		}

		if ( ! empty( $object->data['id'] ) ) {
			$number_comments = get_comments( array(
				'post_id' => $object->data['id'],
				'count'   => true,
				'number'  => 1,
			) );

			if ( 0 < $number_comments ) {
				$number_field_completed++;
			}
		}

		if ( ! empty( $object->data['stopping_days'] ) ) {
			$number_field_completed++;
		}

		if ( ! empty( $object->data['location_of_lesions'] ) ) {
			$number_field_completed++;
		}

		if ( ! empty( $object->data['work_stopping_communication'] ) ) {
			$number_field_completed++;
		}

		if ( ! empty( $object->data['nature_of_lesions'] ) ) {
			$number_field_completed++;
		}

		if ( ! empty( $object->data['name_and_address_of_witnesses'] ) ) {
			$number_field_completed++;
		}

		if ( ! empty( $object->data['name_and_address_of_third_parties_involved'] ) ) {
			$number_field_completed++;
		}

		if ( ! empty( $object->data['observation'] ) ) {
			$number_field_completed++;
		}

		if ( ! empty( $object->data['have_investigation'] ) ) {
			$number_field_completed++;
		}

		$signature_of_the_caregiver_id = (int) get_post_meta( $object->data['id'], 'signature_of_the_caregiver_id', true );
		$signature_of_the_victim_id    = (int) get_post_meta( $object->data['id'], 'signature_of_the_victim_id', true );

		if ( ! empty( $signature_of_the_caregiver_id ) ) {
			$number_field_completed++;
		}

		if ( ! empty( $signature_of_the_victim_id ) ) {
			$number_field_completed++;
		}

		return $number_field_completed;
	}

}

new Accident_Filter();
