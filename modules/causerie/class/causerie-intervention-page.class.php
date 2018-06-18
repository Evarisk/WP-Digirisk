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
	 * @version 6.6.0
	 *
	 * @return void
	 */
	protected function construct() {}

	/**
	 * Appel la vue main.view.php (La vue principale de cette page).
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @param integer $id L'ID de la causerie.
	 *
	 * @return void
	 */
	public function display_single( $id ) {
		$final_causerie = Causerie_Intervention_Class::g()->get( array( 'id' => $id ), true );
		$main_causerie  = Causerie_Class::g()->get( array( 'id' => $final_causerie->parent_id ), true );

		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/main', array(
			'final_causerie' => $final_causerie,
			'main_causerie'  => $main_causerie,
			'all_signed'     => $this->check_all_signed( $final_causerie ),
		) );
	}

	/**
	 * Vérifie si tous les participants ont signés lors de l'intervention.
	 *
	 * Si une personne n'a pas signé, cette méthode retourne false.
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @param  Causerie_Intervention_Model $causerie L'objet Causerie_Intervention_Model.
	 *
	 * @return bool                                  True si toutes les signatures sont présentes. Sinon false.
	 */
	public function check_all_signed( $causerie ) {
		$all_signed = true;

		if ( ! empty( $causerie->participants ) ) {
			foreach ( $causerie->participants as $participant ) {
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
	 * @version 6.6.0
	 *
	 * @param Causerie_Intervention_Model $causerie         L'objet Causerie_Intervention_Model.
	 * @param integer                     $former_id        L'ID du formateur.
	 *
	 * @return Causerie_Intervention_Model                  L'objet Causerie_Intervention_Model avec les données.
	 */
	public function step_former( $causerie, $former_id ) {
		$causerie = Causerie_Intervention_Class::g()->add_participant( $causerie, $former_id, true );

		// Passes à l'étape suivante.
		$causerie->current_step = \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_PRESENTATION;

		return Causerie_Intervention_Class::g()->update( $causerie );
	}

	/**
	 * L'étape de présentation.
	 *
	 * Cette méthode passe seulement à l'étape suivante.
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @param  Causerie_Intervention_Model $causerie L'objet Causerie_Intervention_Model.
	 *
	 * @return Causerie_Intervention_Model           L'objet Causerie_Intervention_Model avec la donnée current_step modifiée.
	 */
	public function step_slider( $causerie ) {
		$causerie->current_step = \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_PARTICIPANT;

		return Causerie_Intervention_Class::g()->update( $causerie );
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
	 * @version 6.6.0
	 *
	 * @param  Causerie_Intervention_Model $causerie_intervention L'objet Causerie_Intervention_Model.
	 * @return Causerie_Intervention_Model                        L'objet Causerie_Intervention_Model avec la donnée current_step modifiée
	 * ainsi que date_end.
	 */
	public function step_participants( $causerie_intervention ) {
		$causerie = Causerie_Class::g()->get( array( 'id' => $causerie_intervention->parent_id ), true );

		$causerie->number_time_realized++;
		$causerie->number_formers++;
		$causerie->number_participants = count( $causerie_intervention->participants );
		$causerie->last_date_realized  = current_time( 'mysql' );

		Causerie_Class::g()->update( $causerie );

		$causerie_intervention->current_step = \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_CLOSED;

		$causerie_intervention->date_end = current_time( 'mysql' );

		Sheet_Causerie_Intervention_Class::g()->generate( $causerie_intervention->id );

		return Causerie_Intervention_Class::g()->update( $causerie_intervention );
	}
}

Causerie_Intervention_Page_Class::g();
