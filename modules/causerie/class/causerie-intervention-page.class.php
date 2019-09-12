<?php
/**
 * Gestion du déroulement de l'intervention du quart d'heure sécurité.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion du déroulement de l'intervention du quart d'heure sécurité.
 */
class Causerie_Intervention_Page_Class extends \eoxia\Singleton_Util {

	/**
	 * Constructeur obligatoire pour Singleton_Util.
	 *
	 * @since   6.6.0
	 */
	protected function construct() {}

	/**
	 * Appel la vue main.view.php (La vue principale de cette page).
	 *
	 * @since   6.6.0
	 *
	 * @param integer $id L'ID de la causerie.
	 */
	public function display_single( $id ) {
		$final_causerie = Causerie_Intervention_Class::g()->get( array( 'id' => $id ), true );
		$final_causerie = apply_filters( 'digi_add_custom_key_to_causerie', $final_causerie );

		$main_causerie  = Causerie_Class::g()->get( array( 'id' => $final_causerie->data['parent_id'] ), true );
		$main_causerie = apply_filters( 'digi_add_custom_key_to_causerie', $main_causerie );

		$user           = null;

		if ( ! empty( $final_causerie->data['former'] ) && ! empty( $final_causerie->data['former']['user_id'] ) ) {
			$user = get_userdata( $final_causerie->data['former']['user_id'] );
		}

		if ( class_exists( 'task_manager\Task_Class' ) && $final_causerie->data['current_step'] == 3 ) {
			$task = \task_manager\Task_Class::g()->get( array( 'post_parent' => $final_causerie->data['id'] ), true );

			if ( empty( $task ) ) {
				$task = Causerie_Intervention_Page_Class::g()->create_task_link_to_causerie( $final_causerie );
			}
		}

		$this->register_search( $final_causerie, $user );

		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/main', array(
			'final_causerie' => $final_causerie,
			'main_causerie'  => $main_causerie,
			'user'           => $user,
			'all_signed'     => $this->check_all_signed( $final_causerie ),
			'task'         => ! empty( $task ) ? $task : array()
		) );
	}

	public function register_search( $causerie, $former ) {
		global $eo_search;

		$args_causerie_former = array(
			'type'         => 'user',
			'name'         => 'former_id',
			'value'        => ! empty( $former ) ? $former->data->display_name : '',
			'hidden_value' => ! empty( $former ) ? (int) $former->data->ID : 0,
		);

		$eo_search->register_search( 'causerie_former', $args_causerie_former );

		$args_causerie_participants = array(
			'type'  => 'user',
			'name'  => 'participant_id',
		);

		$eo_search->register_search( 'causerie_participants', $args_causerie_participants );
	}

	/**
	 * Vérifie si tous les participants ont signés lors de l'intervention.
	 *
	 * Si une personne n'a pas signé, cette méthode retourne false.
	 *
	 * @since   6.6.0
	 *
	 * @param  Causerie_Intervention_Model $causerie L'objet Causerie_Intervention_Model.
	 *
	 * @return bool                                  True si toutes les signatures sont présentes. Sinon false.
	 */
	public function check_all_signed( $causerie ) {
		$all_signed = true;

		if ( empty( $causerie->data['participants'] ) ) {
			$all_signed = false;
		}

		if ( ! empty( $causerie->data['participants'] ) ) {
			foreach ( $causerie->data['participants'] as $participant ) {
				if ( empty( $participant['signature_id'] ) ) {
					$all_signed = false;
					break;
				}
			}
		}

		return $all_signed;
	}

	/**
	 * L'étape du formateur.
	 *
	 * Cette méthode appel "add_participant" de Causerie_Intervention_Class.
	 *
	 * Cette méthode ajoute le formateur à l'objet $causerie.
	 *
	 * @since   6.6.0
	 *
	 * @param Causerie_Intervention_Model $causerie         L'objet Causerie_Intervention_Model.
	 * @param integer                     $former_id        L'ID du formateur.
	 *
	 * @return Causerie_Intervention_Model                  L'objet Causerie_Intervention_Model avec les données.
	 */
	public function step_former( $causerie, $former_id ) {
		$causerie = Causerie_Intervention_Class::g()->add_participant( $causerie, $former_id, true );

		// Passes à l'étape suivante.
		$causerie->data['current_step'] = \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_PRESENTATION;

		return Causerie_Intervention_Class::g()->update( $causerie->data );
	}

	/**
	 * L'étape de présentation.
	 *
	 * Cette méthode passe seulement à l'étape suivante.
	 *
	 * @since   6.6.0
	 *
	 * @param  Causerie_Intervention_Model $causerie L'objet Causerie_Intervention_Model.
	 *
	 * @return Causerie_Intervention_Model           L'objet Causerie_Intervention_Model avec la donnée current_step modifiée.
	 */
	public function step_slider( $causerie, $nextstep ) {
		$causerie->data['current_step'] = $nextstep;
		return Causerie_Intervention_Class::g()->update( $causerie->data );
	}

	/**
	 * L'étapes des participants.
	 *
	 * Met à jour les données compilées la causerie principale:
	 * - Le nombre de fois qu'elle a été réalisé.
	 * - Le nombre de formateur total.
	 * - Le nombre de participant total.
	 * - La dernière date où elle a était réalisé.
	 *
	 * Cette méthode met également à jour l'étape de la causerie "intervention" ainsi que sa date de cloture (date_end).
	 *
	 * Enfin, elle appelle la méthode "generate" de Sheet_Causerie_Intervention_Class pour généré le document ODT.
	 *
	 * @since   6.6.0
	 *
	 * @param  Causerie_Intervention_Model $causerie_intervention L'objet Causerie_Intervention_Model.
	 * @return Causerie_Intervention_Model                        L'objet Causerie_Intervention_Model avec la donnée current_step modifiée
	 * ainsi que date_end.
	 */
	public function step_participants( $causerie_intervention ) {
		$causerie = Causerie_Class::g()->get( array( 'id' => $causerie_intervention->data['parent_id'] ), true );

		$causerie->data['number_time_realized']++;
		$causerie->data['number_formers']++;
		$causerie->data['number_participants'] = count( $causerie_intervention->data['participants'] );
		$causerie->data['last_date_realized']  = current_time( 'mysql' );

		Causerie_Class::g()->update( $causerie->data );

		$causerie_intervention->data['current_step'] = \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_CLOSED;

		$causerie_intervention->data['date_end'] = current_time( 'mysql' );
		$causerie_intervention->data['titreTache'] = 'titre'; // Wtf ? 23/08/2019

		$causerie_intervention = Causerie_Intervention_Class::g()->update( $causerie_intervention->data );

		$response = Sheet_Causerie_Intervention_Class::g()->prepare_document( $causerie_intervention, array( 'causerie' => $causerie ) );
		Sheet_Causerie_Intervention_Class::g()->create_document( $response['document']->data['id'] );

		return $causerie_intervention;
	}

	public function create_task_link_to_causerie( $causerie ){
		$title = __( 'Causerie', 'digirisk' ) . ' ' . $causerie->data['unique_identifier'] . ' ' . $causerie->data['second_identifier'] . ' - ' . __( 'date', 'digirisk' ) . ' ' . date( 'd/m/Y' );

		if( class_exists( 'task_manager\Task_Class' ) ){
			$task_args = array(
				'title'     => $title,
				'parent_id' => $causerie->data['id'],
				'status'    => 'inherit',
			);

			$task = \task_manager\Task_Class::g()->create( $task_args, true );
		}else{
			$task = false;
		}

		return $task;
	}
}

Causerie_Intervention_Page_Class::g();
