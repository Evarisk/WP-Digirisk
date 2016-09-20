<?php if ( !defined( 'ABSPATH' ) ) exit;

class evaluator_class extends user_class {
	protected $model_name 	= '\digi\user_model';
	protected $meta_key		= '_wpeo_user_info';
	protected $after_get_function = array( '\digi\get_hiring_date', 'get_identifier' );

	protected $base 	= 'digirisk/evaluator';
	protected $version 	= '0.1';

	public $element_prefix = 'EV';
	public $limit_evaluator = 5;

	/**
	* Le constructeur
	*/
	protected function construct() {}

	/**
	* Fait le rendu des evaluateurs
	*
	* @param object element L'objet parent
	*/
	public function render( $element ) {
		$list_affected_evaluator = $this->get_list_affected_evaluator( $element );
		$current_page = !empty( $_GET['current_page'] ) ? (int)$_GET['current_page'] : 1;
		$args_where_evaluator = array(
			'offset' => ( $current_page - 1 ) * $this->limit_evaluator,
			'exclude' => array( 1 ),
			'number' => $this->limit_evaluator,
			'meta_query' => array(
				'relation' => 'OR',
			),
		);


		$list_evaluator_to_assign = $this->get( $args_where_evaluator );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset
		unset( $args_where_evaluator['offset'] );
		unset( $args_where_evaluator['number'] );
		$args_where_evaluator['fields'] = array( 'ID' );
		$count_evaluator = count( $this->get( $args_where_evaluator ) );

		$number_page = ceil( $count_evaluator / $this->limit_evaluator );

		require_once( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'main' ) );
	}

	/**
	 * Récupère la liste des utilisateurs affectés avec ses informations d'affectations à cette unité de travail
	 * Get the list of affected evaluators with assignement information for this workunit
	 *
	 * @param int $id The workunit ID
	 * @return object list evaluators affected
	 */
	public function get_list_affected_evaluator( $society ) {
		if ( !is_object( $society ) ) {
			return false;
		}

		if ( $society->id === 0 || empty( $society->user_info ) || empty( $society->user_info['affected_id'] ) )
			return false;


		$list_evaluator = array();
		if ( !empty( $society->user_info['affected_id']['evaluator'] ) ) {
			foreach ( $society->user_info['affected_id']['evaluator'] as $evaluator_id => $array_value ) {
				if ( !empty( $array_value ) ) {
					foreach ( $array_value as $index => $sub_array_value ) {
						if ( !empty( $sub_array_value['status'] ) && $sub_array_value['status'] == 'valid' ) {
							$evaluator = $this->get( array( 'id' => $evaluator_id ) );
							$list_evaluator[ $evaluator_id ][ $index ][ 'user_info' ] = $evaluator[0];
							$list_evaluator[ $evaluator_id ][ $index ][ 'affectation_info' ] = $sub_array_value;
							$list_evaluator[ $evaluator_id ][ $index ][ 'affectation_info' ][ 'id' ] = $index;
						}
					}
				}
			}
		}

		$list_evaluator_affected = array();

		foreach ( $list_evaluator as $evaluator_id => $array_evaluator ) {
			if ( !empty( $array_evaluator ) ) {
				foreach( $array_evaluator as $index => $evaluator ) {
					$list_evaluator_affected[$evaluator['affectation_info']['start']['date']][] = $evaluator;
				}
			}
		}

		sort( $list_evaluator_affected );

		return $list_evaluator_affected;
	}

	/**
	 * Calcul de la durée d'affectation d'un utilisateur selon les dates d'affectation et de désaffectation / User assignment duration calculation depending on assignment and decommissioning dates
	 *
	 * @param array $user_affectation_info Les informations d'affectation de l'utilisateur / User assignment informations
	 *
	 * @return string La durée d'affectation en minutes / Assigment duration in minutes
	 */
	public function get_duration( $user_affectation_info ) {
		if ( empty( $user_affectation_info[ 'start' ][ 'date' ] ) || empty( $user_affectation_info[ 'end' ][ 'date' ] ) )
			return 0;

		$start_date = new DateTime( $user_affectation_info[ 'start' ][ 'date' ] );
		$end_date = new DateTime( $user_affectation_info[ 'end' ][ 'date' ] );
		$interval = $start_date->diff( $end_date );

		$minutes = $interval->format( '%h' ) * 60;
		$minutes += $interval->format( '%i' );

		return $minutes;
	}

}
