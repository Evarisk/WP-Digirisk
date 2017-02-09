<?php
/**
 * Classe gérant les évaluateurs
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package evaluator
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classe gérant les évaluateurs
 */
class Evaluator_Class extends User_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name 	= '\digi\user_digi_model';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key		= '_wpeo_user_info';

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_hiring_date', '\digi\force_avatar_color', '\digi\get_identifier' );

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base 	= 'digirisk/evaluator';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version 	= '0.1';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'U';

	/**
	 * La limite des risques a afficher par page
	 *
	 * @var integer
	 */
	public $limit_evaluator = 5;

	/**
	 * Le constructeur
	 */
	protected function construct() {
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	 * Fait le rendu des evaluateurs
	 *
	 * @param Group_Model $element L'objet parent.
	 * @param integer     $current_page Le numéro de la page pour la pagination.
	 *
	 * @since 1.0
	 * @version 6.2.6.0
	 */
	public function render( $element, $current_page = 1 ) {
		$list_affected_evaluator = $this->get_list_affected_evaluator( $element );
		$current_page = ! empty( $_POST['next_page'] ) ? (int) $_POST['next_page'] : 1;

		$args_where_evaluator = array(
			'offset' => ( $current_page - 1 ) * $this->limit_evaluator,
			'exclude' => array( 1 ),
			'number' => $this->limit_evaluator,
			'meta_query' => array(
				'relation' => 'OR',
			),
		);

		$evaluators = $this->get( $args_where_evaluator );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset.
		unset( $args_where_evaluator['offset'] );
		unset( $args_where_evaluator['number'] );
		$args_where_evaluator['fields'] = array( 'ID' );
		$count_evaluator = count( $this->get( $args_where_evaluator ) );

		$number_page = ceil( $count_evaluator / $this->limit_evaluator );

		View_Util::exec( 'evaluator', 'main', array(
			'element' => $element,
			'evaluators' => $evaluators,
			'list_affected_evaluator' => $list_affected_evaluator,
			'number_page' => $number_page,
			'current_page' => $current_page,
		) );
	}

	/**
	 * Récupère la liste des évaluateurs affectés avec ses informations d'affectations à ce groupement
	 *
	 * @param Group_Model $society La société.
	 * @return array
	 *
	 * @since 1.0
	 * @version 6.2.4.0
	 */
	public function get_list_affected_evaluator( $society ) {
		if ( 0 === $society->id || empty( $society->user_info ) || empty( $society->user_info['affected_id'] ) ) {
			return false;
		}

		$list_evaluator = array();
		if ( ! empty( $society->user_info['affected_id']['evaluator'] ) ) {
			foreach ( $society->user_info['affected_id']['evaluator'] as $evaluator_id => $array_value ) {
				if ( ! empty( $array_value ) ) {
					foreach ( $array_value as $index => $sub_array_value ) {
						if ( ! empty( $sub_array_value['status'] ) && 'valid' === $sub_array_value['status'] ) {
							$evaluator = $this->get( array( 'id' => $evaluator_id ) );
							$list_evaluator[ $evaluator_id ][ $index ]['user_info'] = $evaluator[0];
							$list_evaluator[ $evaluator_id ][ $index ]['affectation_info'] = $sub_array_value;
							$list_evaluator[ $evaluator_id ][ $index ]['affectation_info']['id'] = $index;
						}
					}
				}
			}
		}

		$list_evaluator_affected = array();

		foreach ( $list_evaluator as $evaluator_id => $array_evaluator ) {
			if ( ! empty( $array_evaluator ) ) {
				foreach ( $array_evaluator as $index => $evaluator ) {
					$list_evaluator_affected[ $evaluator['affectation_info']['start']['date'] ][] = $evaluator;
				}
			}
		}

		sort( $list_evaluator_affected );

		return $list_evaluator_affected;
	}

	/**
	 * Calcul de la durée d'affectation d'un utilisateur selon les dates d'affectation et de désaffectation / User assignment duration calculation depending on assignment and decommissioning dates
	 *
	 * @param array $user_affectation_info Les informations d'affectation de l'utilisateur / User assignment informations.
	 *
	 * @return string La durée d'affectation en minutes / Assigment duration in minutes
	 *
	 * @since 1.0
	 * @version 6.2.4.0
	 */
	public function get_duration( $user_affectation_info ) {
		if ( empty( $user_affectation_info['start']['date'] ) || empty( $user_affectation_info['end']['date'] ) ) {
			return 0;
		}

		$start_date = new \DateTime( $user_affectation_info['start']['date'] );
		$end_date = new \DateTime( $user_affectation_info['end']['date'] );
		$interval = $start_date->diff( $end_date );

		$minutes = $interval->format( '%h' ) * 60;
		$minutes += $interval->format( '%i' );

		return $minutes;
	}

}
