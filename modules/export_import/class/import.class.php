<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
* Fichier de gestion des actions pour le tableau de bord de Digirisk / File for managing Digirisk dashboard
*
* @author Alexandre Techer <dev@evarisk.com>
* @since 6.1.5.5
* @copyright 2015-2016 Evarisk
* @package Digirisk\dashboard
* @subpackage class
*/

/**
* Classe de gestion des actions pour les exports et imports des données de Digirisk / Class for managing export and import for Digirisk datas
*
* @author Alexandre Techer <dev@evarisk.com>
* @since 6.1.5.5
* @copyright 2015-2016 Evarisk
* @package Digirisk\dashboard
* @subpackage class
*/
class import_class extends singleton_util {

	/**
	 * Constructeur de la classe. Doit être présent même si vide pour coller à la définition "abstract" des parents / Class constructor. Must be present even if empty for matchin with "abstract" definition of ancestors
	 */
	function construct() {}

	public function create( $data ) {
		if ( !empty( $data ) ) {
			$this->create_groupment( $data );
		}
	}

	public function create_groupment( $data ) {
	  foreach ( $data as $groupment_json ) {
			$groupment = group_class::g()->update( $groupment_json );

			if ( !empty( $groupment_json['list_risk'] ) ) {
			  foreach ( $groupment_json['list_risk'] as $risk_json ) {
					$this->create_risk( $groupment, $risk_json );
			  }
			}

			if ( !empty( $groupment_json['list_workunit'] ) ) {
			  foreach ( $groupment_json['list_workunit'] as $workunit_json ) {
					$this->create_workunit( $groupment, $workunit_json );
			  }
			}
	  }
	}

	public function create_workunit( $groupment, $workunit_json ) {
		$workunit_json['parent_id'] = $groupment->id;
		$workunit = workunit_class::g()->update( $workunit_json );

		if ( !empty( $workunit_json['list_risk'] ) ) {
		  foreach ( $workunit_json['list_risk'] as $risk_json ) {
				$this->create_risk( $workunit, $risk_json );
		  }
		}
	}

	public function create_risk( $society, $risk_json ) {
		$risk_json['parent_id'] = $society->id;
		$risk = risk_class::g()->update( $risk_json );

		if ( !empty( $risk_json['evaluation'] ) ) {
		  foreach ( $risk_json['evaluation'] as $evaluation_json ) {
				$this->create_risk_evaluation( $risk, $risk_json['comment'], $evaluation_json );
		  }
		}

		if ( !empty( $risk_json['danger_category'] ) ) {
			foreach( $risk_json['danger_category'] as $danger_category_json ) {
				$this->create_danger_category( $risk, $danger_category_json );
			}
		}
	}

	public function create_risk_evaluation( $risk, $risk_comment_json, $evaluation_json ) {
		$evaluation_json['post_id'] = $risk->id;
		$risk_evaluation = risk_evaluation_class::g()->update( $evaluation_json );
		$risk->current_evaluation_id = $risk_evaluation->id;
		$risk = risk_class::g()->update( $risk );

		if ( !empty( $risk_comment_json ) ) {
		  foreach ( $risk_comment_json as $comment_json ) {
				$this->create_risk_evaluation_comment( $risk, $risk_evaluation, $comment_json );
		  }
		}
	}

	public function create_risk_evaluation_comment( $risk, $risk_evaluation, $comment_json ) {
		$comment_json['post_id'] = $risk->id;
		$comment_json['parent_id'] = $risk_evaluation->id;
		risk_evaluation_comment_class::g()->update( $comment_json );
	}

	public function create_danger_category( $risk, $danger_category_json ) {
		$danger_category = danger_category_class::g()->update( $danger_category_json );
		$risk->taxonomy['digi-danger-category'][] = $danger_category->id;
		$risk = risk_class::g()->update( $risk );

		if ( !empty( $danger_category_json['danger'] ) ) {
		  foreach ( $danger_category_json['danger'] as $danger_json ) {
				$this->create_danger( $risk, $danger_category, $danger_json );
		  }
		}
	}

	public function create_danger( $risk, $danger_category, $danger_json ) {
		$danger = danger_class::g()->update( $danger_json );
		$risk->taxonomy['digi-danger'][] = $danger->id;
		$risk = risk_class::g()->update( $risk );
	}
}
