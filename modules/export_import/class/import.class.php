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
	private $index;
	private $data;
	/**
	 * Constructeur de la classe. Doit être présent même si vide pour coller à la définition "abstract" des parents / Class constructor. Must be present even if empty for matchin with "abstract" definition of ancestors
	 */
	function construct() {}

	public function create( $data ) {
		$this->index = 0;
		$this->data = $data;

		if ( !empty( $this->data ) ) {
			foreach( $this->data as &$groupment_json ) {
				$this->create_groupment( $groupment_json );
			}

			import_action::$response['index_element']++;
			import_action::g()->fast_response( true );
		}
	}

	public function create_groupment( &$groupment_json, $groupment = null ) {
		if ( empty( $groupment_json['id'] ) ) {
			if ( $groupment ) {
				$groupment_json['parent_id'] = $groupment->id;
			}

			$groupment = group_class::g()->update( $groupment_json );
			$groupment_json['id'] = $groupment->id;
			$this->update_json_file();
			$this->check_index();
		}
		else {
			$groupment = group_class::g()->get( array( 'include' => $groupment_json['id'] ) );
			$groupment = $groupment[0];
		}

		if ( !empty( $groupment_json['list_risk'] ) ) {
		  foreach ( $groupment_json['list_risk'] as &$risk_json ) {
				$this->create_risk( $groupment, $risk_json );
		  }
		}

		if ( !empty( $groupment_json['list_workunit'] ) ) {
		  foreach ( $groupment_json['list_workunit'] as &$workunit_json ) {
				$this->create_workunit( $groupment, $workunit_json );
		  }
		}

		if ( !empty( $groupment_json['list_group'] ) ) {
			foreach ( $groupment_json['list_group'] as &$groupment_json ) {
				$this->create_groupment( $groupment_json, $groupment );
			}
		}
	}

	public function create_workunit( $groupment, &$workunit_json ) {
		if ( empty( $workunit_json['id'] ) ) {
			$workunit_json['parent_id'] = $groupment->id;
			$workunit = workunit_class::g()->update( $workunit_json );
			$workunit_json['id'] = $workunit->id;
			$this->update_json_file();
			$this->check_index();
		}
		else {
			$workunit = workunit_class::g()->get( array( 'include' => $workunit_json['id'] ) );
			$workunit = $workunit[0];
		}

		if ( !empty( $workunit_json['list_risk'] ) ) {
		  foreach ( $workunit_json['list_risk'] as &$risk_json ) {
				$this->create_risk( $workunit, $risk_json );
		  }
		}
	}

	public function create_risk( $society, &$risk_json ) {
		if ( empty( $risk_json['id'] ) ) {
			$risk_json['parent_id'] = $society->id;
			$risk = risk_class::g()->update( $risk_json );
			$risk_json['id'] = $risk->id;
			$this->update_json_file();
			$this->check_index();
		}
		else {
			$risk = risk_class::g()->get( array( 'include' => $risk_json['id'] ) );
			$risk = $risk[0];
		}

		if ( !empty( $risk_json['evaluation'] ) ) {
		  foreach ( $risk_json['evaluation'] as &$evaluation_json ) {
				$this->create_risk_evaluation( $risk, $risk_json['comment'], $evaluation_json );
		  }
		}

		if ( !empty( $risk_json['danger_category'] ) ) {
			foreach( $risk_json['danger_category'] as &$danger_category_json ) {
				$this->create_danger_category( $risk, $danger_category_json );
			}
		}

		if ( !empty( $risk_json['evaluation_method'] ) ) {
		  foreach ( $risk_json['evaluation_method'] as &$evaluation_method_json ) {
				$this->create_evaluation_method( $risk, $evaluation_method_json );
		  }
		}
	}

	public function create_risk_evaluation( $risk, &$risk_comment_json, &$evaluation_json ) {
		if ( empty( $evaluation_json['id'] ) ) {
			$evaluation_json['post_id'] = $risk->id;
			$risk_evaluation = risk_evaluation_class::g()->update( $evaluation_json );
			$risk->current_evaluation_id = $risk_evaluation->id;
			$risk = risk_class::g()->update( $risk );
			$evaluation_json['id'] = $risk_evaluation->id;
			$this->update_json_file();
			$this->check_index();
		}
		else {
			$risk_evaluation = risk_evaluation_class::g()->get( array( 'comment__in' => $evaluation_json['id'] ) );
			$risk_evaluation = $risk_evaluation[0];
		}

		if ( !empty( $risk_comment_json ) ) {
		  foreach ( $risk_comment_json as &$comment_json ) {
				$this->create_risk_evaluation_comment( $risk, $risk_evaluation, $comment_json );
		  }
		}
	}

	public function create_risk_evaluation_comment( $risk, $risk_evaluation, &$comment_json ) {
		if ( empty( $comment_json['id'] ) ) {
			$comment_json['post_id'] = $risk->id;
			$comment_json['parent_id'] = $risk_evaluation->id;
			$comment_json['author_id'] = get_current_user_id();
			$risk_evaluation_comment = risk_evaluation_comment_class::g()->update( $comment_json );
			$comment_json['id'] = $risk_evaluation_comment->id;
			$this->update_json_file();
			$this->check_index();
		}
	}

	public function create_danger_category( $risk, &$danger_category_json ) {
		if ( empty( $danger_category_json['id'] ) ) {
			$danger_category = category_danger_class::g()->update( $danger_category_json );
			$risk->taxonomy['digi-danger-category'][] = $danger_category->id;
			$risk = risk_class::g()->update( $risk );
			$danger_category_json['id'] = $danger_category->id;
			$this->update_json_file();
			$this->check_index();
		}
		else {
			$danger_category = category_danger_class::g()->get( array( 'include' => $danger_category_json['id'] ) );
			$danger_category = $danger_category[0];
		}

		if ( !empty( $danger_category_json['danger'] ) ) {
		  foreach ( $danger_category_json['danger'] as &$danger_json ) {
				$this->create_danger( $risk, $danger_category, $danger_json );
		  }
		}
	}

	public function create_danger( $risk, $danger_category, &$danger_json ) {
		if ( empty( $danger_json['id'] ) ) {
			$danger_json['parent_id'] = $danger_category->id;
			$danger = danger_class::g()->update( $danger_json );
			$risk->taxonomy['digi-danger'][] = $danger->id;
			$risk = risk_class::g()->update( $risk );
			$danger_json['id'] = $danger->id;
			$this->update_json_file();
			$this->check_index();
		}
	}

	public function create_evaluation_method( $risk, &$evaluation_method_json ) {
		if ( empty( $evaluation_method_json['id'] ) ) {
			$evaluation_method = evaluation_method_class::g()->update( $evaluation_method_json );
			$risk->taxonomy['digi-method'][] = $evaluation_method->id;
			$risk = risk_class::g()->update( $risk );
			$evaluation_method_json['id'] = $evaluation_method->id;
			$this->update_json_file();
			$this->check_index();
		}
		else {
			$evaluation_method = evaluation_method_class::g()->get( array( 'include' => $evaluation_method_json['id'] ) );
			$evaluation_method = $evaluation_method[0];
		}

		if ( !empty( $evaluation_method_json['variable'] ) ) {
		  foreach ( $evaluation_method_json['variable'] as &$evaluation_method_variable_json ) {
				$this->create_evaluation_method_variable( $evaluation_method, $evaluation_method_variable_json );
		  }
		}
	}

	public function create_evaluation_method_variable( $evaluation_method, &$evaluation_method_variable_json ) {
		if ( empty( $evaluation_method_variable_json['id'] ) ) {
			$evaluation_method_variable_json['parent_id'] = $evaluation_method->id;
			$evaluation_method_variable = evaluation_method_variable_class::g()->update( $evaluation_method_variable_json );
			$evaluation_method_variable_json['id'] = $evaluation_method_variable->id;
			import_action::$response['element'] = $evaluation_method->slug . ' ' . $evaluation_method_variable->slug;
			$this->update_json_file();
			$this->check_index();
		}
	}

	private function update_json_file() {
		file_put_contents( import_action::$response['path_to_json'], json_encode( $this->data, JSON_PRETTY_PRINT ) );
	}

	private function check_index() {
		$this->index++;
		import_action::$response['index_element']++;

		if ( $this->index >= 100 ) {
			import_action::g()->fast_response();
		}
	}
}
