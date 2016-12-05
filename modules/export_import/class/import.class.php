<?php
/**
 * Gestion de l'importation des modèles
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 *
 * @since 6.1.5.5
 * @version 6.2.1.2
 *
 * @copyright 2015-2016 Evarisk
 *
 * @package Digirisk\export_import
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Gestion de l'importation des modèles
 */
class Import_Class extends Singleton_Util {
	/**
	 * La clé courante pour l'élément
	 *
	 * @var integer
	 */
	private $index;

	/**
	 * Les données à importer
	 *
	 * @var array
	 */
	private $data;


	/**
	 * Le constructeur
	 */
	function construct() {}

	/**
	 * Appelle la méthode create_groupement avec les données d'un groupement
	 *
	 * @since 6.1.5.5
	 * @version 6.2.1.2
	 *
	 * @param  array $data  Les données à importer.
	 *
	 * @return void
	 */
	public function create( $data ) {
		$this->index = 0;
		$this->data = $data;

		if ( ! empty( $this->data ) ) {
			foreach ( $this->data as &$groupment_json ) {
				$this->create_groupment( $groupment_json );
			}

			import_action::$response['index_element']++;
			import_action::g()->fast_response( true );
		}
	}

	/**
	 * Créer un groupement par rapport au donnée contenant dans le JSON.
	 * Récupères le groupement si celui-ci existe déjà. (Vérification grâce à l'ID)
	 * Appelles les méthodes suivantes:
	 * update_json_file: pour mêttre à jour le fichier JSON.
	 * check_index: pour vérifier que $response['index_element'] n'est pas dépassé 100.
	 * create_risk: pour créer les risques enfants au groupement.
	 * create_workunit: pour créer les unités de travail enfants au groupement.
	 * create_groupmennt: pour crér les groupements enfants au groupement.
	 *
	 * @since 6.1.5.5
	 * @version 6.2.1.2
	 *
	 * @param  array       $groupment_json Les données du groupement comprenant les enfants.
	 * @param  Group_Model $groupment (optional) Les données du groupement créé grâce à cette méthode.
	 *
	 * @return void
	 */
	public function create_groupment( &$groupment_json, $groupment = null ) {
		if ( empty( $groupment_json['id'] ) ) {
			if ( $groupment ) {
				$groupment_json['parent_id'] = $groupment->id;
			}

			$groupment = group_class::g()->update( $groupment_json );
			$groupment_json['id'] = $groupment->id;
			$this->update_json_file();
			$this->check_index();
		} else {
			$groupment = group_class::g()->get( array( 'include' => $groupment_json['id'] ) );
			$groupment = $groupment[0];
		}

		if ( ! empty( $groupment_json['list_risk'] ) ) {
			foreach ( $groupment_json['list_risk'] as &$risk_json ) {
				$this->create_risk( $groupment, $risk_json );
			}
		}

		if ( ! empty( $groupment_json['list_workunit'] ) ) {
			foreach ( $groupment_json['list_workunit'] as &$workunit_json ) {
				$this->create_workunit( $groupment, $workunit_json );
			}
		}

		if ( ! empty( $groupment_json['list_group'] ) ) {
			foreach ( $groupment_json['list_group'] as &$groupment_json ) {
				$this->create_groupment( $groupment_json, $groupment );
			}
		}
	}

	/**
	 * Créer une unité de travail
	 *
	 * @since 6.1.5.5
	 * @version 6.2.1.2
	 *
	 * @param  Group_Model $groupment 			Les données du groupement.
	 * @param  array       $workunit_json 	Les données venant du fichier JSON.
	 *
	 * @return void
	 */
	public function create_workunit( $groupment, &$workunit_json ) {
		if ( empty( $workunit_json['id'] ) ) {
			$workunit_json['parent_id'] = $groupment->id;
			$workunit = workunit_class::g()->update( $workunit_json );
			$workunit_json['id'] = $workunit->id;
			$this->update_json_file();
			$this->check_index();
		} else {
			$workunit = workunit_class::g()->get( array( 'include' => $workunit_json['id'] ) );
			$workunit = $workunit[0];
		}

		if ( ! empty( $workunit_json['list_risk'] ) ) {
			foreach ( $workunit_json['list_risk'] as &$risk_json ) {
				$this->create_risk( $workunit, $risk_json );
			}
		}
	}

	/**
	 * Créer un risque
	 *
	 * @since 6.1.5.5
	 * @version 6.2.1.2
	 *
	 * @param  Workunit_Model|Group_Model $society 		Les données du groupement.
	 * @param  array                      $risk_json 	Les données du risque à créer.
	 *
	 * @return void
	 */
	public function create_risk( $society, &$risk_json ) {
		if ( empty( $risk_json['id'] ) ) {
			$risk_json['parent_id'] = $society->id;
			$risk = risk_class::g()->update( $risk_json );
			$risk_json['id'] = $risk->id;
			$this->update_json_file();
			$this->check_index();
		} else {
			$risk = risk_class::g()->get( array( 'include' => $risk_json['id'] ) );
			$risk = $risk[0];
		}

		if ( ! empty( $risk_json['evaluation'] ) ) {
			$this->create_risk_evaluation( $risk, $risk_json['comment'], $risk_json['evaluation'] );
		}

		if ( ! empty( $risk_json['danger_category'] ) ) {
			$this->create_danger_category( $risk, $risk_json['danger_category'] );
		}

		if ( ! empty( $risk_json['evaluation_method'] ) ) {
			$this->create_evaluation_method( $risk, $risk_json['evaluation_method'] );
		}
	}

	/**
	 * Créer une évaluation d'un risque
	 *
	 * @since 6.1.5.5
	 * @version 6.2.1.2
	 *
	 * @param  Risk_Model $risk              Le risque créé par la méthode create_risk.
	 * @param  array      $risk_comment_json Les commentaires du risque qui sera créé par la méthode create_risk_evaluation_comment appelée par cette méthode.
	 * @param  array      $evaluation_json   Les données de l'évaluation du risque à créer cette méthode.
	 * @return void
	 */
	public function create_risk_evaluation( $risk, &$risk_comment_json, &$evaluation_json ) {
		if ( empty( $evaluation_json['id'] ) ) {
			$evaluation_json['post_id'] = $risk->id;
			$risk_evaluation = risk_evaluation_class::g()->update( $evaluation_json );
			$risk->current_evaluation_id = $risk_evaluation->id;
			$risk = risk_class::g()->update( $risk );
			$evaluation_json['id'] = $risk_evaluation->id;
			$this->update_json_file();
			$this->check_index();
		} else {
			$risk_evaluation = risk_evaluation_class::g()->get( array( 'comment__in' => $evaluation_json['id'] ) );
			$risk_evaluation = $risk_evaluation[0];
		}

		if ( ! empty( $risk_comment_json ) ) {
			foreach ( $risk_comment_json as &$comment_json ) {
				$this->create_risk_evaluation_comment( $risk, $risk_evaluation, $comment_json );
			}
		}
	}

	/**
	 * Créer les commentaires de l'évaluation du risque.
	 *
	 * @since 6.1.5.5
	 * @version 6.1.5.5
	 *
	 * @param  Risk_Model            $risk            Le risque créé par la méthode create_risk.
	 * @param  Risk_Evaluation_Model $risk_evaluation L'évaluation du risque créé par la méthode create_risk_evaluation.
	 * @param  array                 $comment_json Les commentaires du risque à créer par cette méthode.
	 * @return void
	 */
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

	/**
	 * Créer la catégorie du danger
	 *
	 * @since 6.1.5.5
	 * @version 6.1.5.5
	 *
	 * @param  Risk_Model $risk                 Le risque créé par la méthode create_risk.
	 * @param  array      $danger_category_json Les données de la catégorie de danger à créer dans cette méthode.
	 * @return void
	 */
	public function create_danger_category( $risk, &$danger_category_json ) {
		if ( empty( $danger_category_json['id'] ) ) {
			$danger_category = category_danger_class::g()->update( $danger_category_json );
			$risk->taxonomy['digi-danger-category'][] = $danger_category->id;
			$risk = risk_class::g()->update( $risk );
			$danger_category_json['id'] = $danger_category->id;
			$this->update_json_file();
			$this->check_index();
		} else {
			$danger_category = category_danger_class::g()->get( array( 'include' => $danger_category_json['id'] ) );
			$danger_category = $danger_category[0];
		}

		if ( ! empty( $danger_category_json['danger'] ) ) {
			$this->create_danger( $risk, $danger_category, $danger_category_json['danger'] );
		}
	}

	/**
	 * Créer un danger selon $danger_json
	 *
	 * @since 6.1.5.5
	 * @version 6.1.5.5
	 *
	 * @param  Risk_Model $risk            Les données du risque créer par la méthode create_risk.
	 * @param  array      $danger_category Les données de la catégorie du danger créé par la méthode create_danger_category.
	 * @param  array      $danger_json     Les données du fichier JSON pour créer le danger.
	 * @return void
	 */
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

	/**
	 * Créer la méthode d'évaluation
	 *
	 * @since 6.1.5.5
	 * @version 6.1.5.5
	 *
	 * @param  Risk_Model $risk                   Les données du risque créer par la méthode create_risk.
	 * @param  array      $evaluation_method_json La données de la méthode d'évaluation à créer par cette méthode.
	 * @return void
	 */
	public function create_evaluation_method( $risk, &$evaluation_method_json ) {
		if ( empty( $evaluation_method_json['id'] ) ) {
			$evaluation_method = evaluation_method_class::g()->update( $evaluation_method_json );
			$risk->taxonomy['digi-method'][] = $evaluation_method->id;
			$risk = risk_class::g()->update( $risk );
			$evaluation_method_json['id'] = $evaluation_method->id;
			$this->update_json_file();
			$this->check_index();
		} else {
			$evaluation_method = evaluation_method_class::g()->get( array( 'include' => $evaluation_method_json['id'] ) );
			$evaluation_method = $evaluation_method[0];
		}

		if ( ! empty( $evaluation_method_json['variable'] ) ) {
			foreach ( $evaluation_method_json['variable'] as &$evaluation_method_variable_json ) {
				$this->create_evaluation_method_variable( $evaluation_method, $evaluation_method_variable_json );
			}
		}
	}

	/**
	 * Les variables de la méthode d'évaluation
	 *
	 * @since 6.1.5.5
	 * @version 6.1.5.5
	 *
	 * @param  Evaluation_Method_Model $evaluation_method               Les données de la méthode d'évaluation créer par la méthode create_evaluation_method.
	 * @param  array                   $evaluation_method_variable_json Les données des variables d'évaluation à créer par cette méthode.
	 * @return void
	 */
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

	/**
	 * Met à jour le fichier JSON
	 *
	 * @since 6.1.5.5
	 * @version 6.1.5.5
	 *
	 * @return void
	 */
	private function update_json_file() {
		file_put_contents( import_action::$response['path_to_json'], wp_json_encode( $this->data, JSON_PRETTY_PRINT ) );
	}

	/**
	 * Vérifie l'index actuel dans la requête XHR.
	 * Si elle dépasse le nombre 100 (non personnalisable) on renvoie la réponse à la requête. (Permet d'éviter les requêtes trop longue)
	 *
	 * @since 6.1.5.5
	 * @version 6.1.5.5
	 *
	 * @return void
	 */
	private function check_index() {
		$this->index++;
		import_action::$response['index_element']++;

		if ( $this->index >= 100 ) {
			import_action::g()->fast_response();
		}
	}
}
