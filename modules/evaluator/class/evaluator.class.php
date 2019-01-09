<?php
/**
 * Classe gérant les évaluateurs
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.2.3
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les évaluateurs
 */
class Evaluator_Class extends \eoxia\User_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\User_Model';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpeo_user_info';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'evaluator';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

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
	 * Fait le rendu des evaluateurs
	 *
	 * @since 6.0.0
	 *
	 * @param Group_Model $element L'objet parent.
	 * @param integer     $current_page Le numéro de la page pour la pagination.
	 */
	public function render( $element, $current_page = 1 ) {
		global $eo_search;

		$list_affected_evaluator = $this->get_list_affected_evaluator( $element );
		$current_page            = ! empty( $_POST['next_page'] ) ? (int) $_POST['next_page'] : 1; // WPCS: input var ok.

		$args_where_evaluator = array(
			'offset'     => ( $current_page - 1 ) * $this->limit_evaluator,
			'exclude'    => array( 1 ),
			'number'     => $this->limit_evaluator,
			'meta_query' => array(
				'relation' => 'OR',
			),
		);

		$evaluators = User_Class::g()->get( $args_where_evaluator );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset.
		unset( $args_where_evaluator['offset'] );
		unset( $args_where_evaluator['number'] );
		$args_where_evaluator['fields'] = array( 'ID' );
		$count_evaluator                = count( User_Class::g()->get( $args_where_evaluator ) );

		$number_page = ceil( $count_evaluator / $this->limit_evaluator );

		$eo_search->register_search( 'evaluator_to_assign', array(
			'icon'        => 'fa-search',
			'type'        => 'user',
			'name'        => 'evaluator',
			'next_action' => 'display_evaluator_to_assign',
			'post_id'     => $element->data['id'],
		) );

		$eo_search->register_search( 'evaluator_affected', array(
			'icon'        => 'fa-search',
			'type'        => 'user',
			'name'        => 'evaluator',
			'next_action' => 'display_evaluator_affected',
			'post_id'     => $element->data['id'],
		) );

		\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'main', array(
			'element'                 => $element,
			'evaluators'              => $evaluators,
			'list_affected_evaluator' => $list_affected_evaluator,
			'number_page'             => $number_page,
			'current_page'            => $current_page,
		) );
	}

	/**
	 * Récupère la liste des évaluateurs affectés avec ses informations d'affectations à ce groupement
	 *
	 * @param Group_Model $society La société.
	 * @return array
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 */
	public function get_list_affected_evaluator( $society ) {
		if ( 0 === $society->data['id'] || empty( $society->data['user_info'] ) || empty( $society->data['user_info']['affected_id'] ) ) {
			return false;
		}

		$list_evaluator = array();
		if ( ! empty( $society->data['user_info']['affected_id']['evaluator'] ) ) {
			foreach ( $society->data['user_info']['affected_id']['evaluator'] as $evaluator_id => $array_value ) {
				if ( ! empty( $array_value ) ) {
					foreach ( $array_value as $index => $sub_array_value ) {
						if ( ! empty( $sub_array_value['status'] ) && 'valid' === $sub_array_value['status'] ) {
							$evaluator = User_Class::g()->get( array( 'id' => $evaluator_id ), true );
							$list_evaluator[ $evaluator_id ][ $index ]['user_info']              = $evaluator;
							$list_evaluator[ $evaluator_id ][ $index ]['affectation_info']       = $sub_array_value;
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

		krsort( $list_evaluator_affected );

		return $list_evaluator_affected;
	}

	/**
	 * Calcul de la durée d'affectation d'un utilisateur selon les dates d'affectation et de désaffectation / User assignment duration calculation depending on assignment and decommissioning dates
	 *
	 * @since 6.0.0
	 *
	 * @param array $user_affectation_info Les informations d'affectation de l'utilisateur / User assignment informations.
	 *
	 * @return string La durée d'affectation en minutes / Assigment duration in minutes
	 */
	public function get_duration( $user_affectation_info ) {
		if ( empty( $user_affectation_info['start']['date'] ) || empty( $user_affectation_info['end']['date'] ) ) {
			return 0;
		}

		$start_date = new \DateTime( $user_affectation_info['start']['date'] );
		$end_date   = new \DateTime( $user_affectation_info['end']['date'] );
		$interval   = $start_date->diff( $end_date );

		$minutes  = $interval->format( '%h' ) * 60;
		$minutes += $interval->format( '%i' );

		return $minutes;
	}

	/**
	 * Affectes un évaluateur à la société.
	 *
	 * @since 7.0.0
	 *
	 * @param  mixed   $society  Les données de la société.
	 * @param  integer $user_id  L'ID de l'utilisateur.
	 * @param  array   $data     Les données pour l'affectation.
	 *
	 * @return Evaluator_Model   Les données de l'évaluateur.
	 */
	public function affect_user( $society, $user_id, $data ) {
		$end_date = new \DateTime( $data['on'] );
		$end_date->add( new \DateInterval( 'PT' . $data['duration'] . 'M' ) );

		$evaluator = Evaluator_Class::g()->get( array( 'id' => $user_id ), true );

		$society->data['user_info']['affected_id']['evaluator'][ $user_id ][] = array(
			'status' => 'valid',
			'start'  => array(
				'date' => $data['on'],
				'by'   => get_current_user_id(),
				'on'   => current_time( 'mysql' ),
			),
			'end'    => array(
				'date' => sanitize_text_field( $end_date->format( 'Y-m-d H:i:s' ) ),
				'by'   => get_current_user_id(),
				'on'   => current_time( 'mysql' ),
			),
		);

		Society_Class::g()->update_by_type( $society );

		return $evaluator;
	}

}
