<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class tools_class extends singleton_util {

	protected function construct() { }

	public function reset_method_evaluation() {
		// Récupères la méthode d'évaluation
    $term_method_evarisk = get_term_by( 'slug', 'evarisk', evaluation_method_class::g()->get_taxonomy() );
    $method_evaluation = evaluation_method_class::g()->get( array( 'id' => $term_method_evarisk->term_id ) );
		$method_evaluation = $method_evaluation[0];

		$list_old_variable_id = array();
		$list_new_variable_id = array();

    // Suppresion de toutes les variables actuelles.
    if ( !empty( $method_evaluation->formula ) ) {
      foreach ( $method_evaluation->formula as $element ) {
        if ( $element != '*' ) {
          wp_delete_term( (int) $element, evaluation_method_class::g()->get_taxonomy() );

					if ( !in_array( (int) $element, $list_old_variable_id ) ) {
						$list_old_variable_id[] = (int)$element;
					}
        }
      }
    }

    // Suppresion également des variables par leurs noms ( Au cas ou certains sont passé à coté de la première suppression )
    $array_slug = array( 'Gravite', 'Exposition', 'Occurence', 'Formation', 'Protection' );
    foreach ( $array_slug as $element ) {
      $term = get_term_by( 'name', $element, evaluation_method_variable_class::g()->get_taxonomy() );
      if ( !empty( $term ) && ( $term->term_id ) ) {
        // evaluation_method_variable_class::g()->delete( $term->term_id ); Ne supprimes pas le term ? bug
        wp_delete_term( $term->term_id, evaluation_method_variable_class::g()->get_taxonomy() );

				if ( !in_array( $term->term_id, $list_old_variable_id ) ) {
					$list_old_variable_id[] = $term->term_id;
				}
      }
    }

    // On met à jours la méthode d'évaluation pour enlever les formules
    unset( $method_evaluation->formula );
    $method_evaluation = evaluation_method_class::g()->update( $method_evaluation );

    // Ajout des nouvelles variables
    $file_content = file_get_contents( PLUGIN_DIGIRISK_PATH . config_util::$init['evaluation_method']->path . 'asset/json/default.json' );
		$data = json_decode( $file_content );

    $data_variable_evarisk = array();

    if ( !empty( $data ) ) {
      foreach ( $data as $element ) {
        if ( $element->name == 'Evarisk' ) {
          $data_variable_evarisk = $element->option->variable;
          break;
        }
      }
    }

    // Si la méthode d'évaluation evarisk n'existe pas on stop le script
    if ( empty( $data_variable_evarisk ) ) {
      wp_send_json_error();
    }

    foreach ( $data_variable_evarisk as $element ) {
      $term_id = tools_class::g()->add_variable( $method_evaluation, $element );

			if ( !in_array( $term_id, $list_new_variable_id ) ) {
				$list_new_variable_id[] = $term_id;
			}
    }

		tools_class::g()->fix_all_risk( $term_method_evarisk->term_id, $list_old_variable_id, $list_new_variable_id);
	}

  public function add_variable( $method_evaluation, $variable ) {
    // On tente de crée les variables de la méthode d'évaluation
    $evaluation_method_variable = evaluation_method_variable_class::g()->create( array(
        'name' => $variable->name,
        'description' => $variable->description,
        'display_type' => $variable->option->display_type,
        'range' => $variable->option->range,
        'survey' => $variable->option->survey,
    ) );

    if ( !is_wp_error( $evaluation_method_variable ) ) {
      $method_evaluation->formula[] = $evaluation_method_variable->id;
      $method_evaluation->formula[] = "*";

      $method_evaluation = evaluation_method_class::g()->update( $method_evaluation );
    }

		return $evaluation_method_variable->id;
  }

	public function fix_all_risk( $term_method_evarisk_id, $list_old_variable_id, $list_new_variable_id ) {
		global $wpdb;
		$list_risk = array();
		$list_risk_evaluation = array();

		// On récupère les risques
		$query = "SELECT ID FROM {$wpdb->posts} WHERE post_type=%s";
		$list_post = $wpdb->get_results( $wpdb->prepare( $query, array( risk_class::g()->get_post_type() ) ) );

		if ( !empty( $list_post ) ) {
		  foreach ( $list_post as $element ) {
				$risk = risk_class::g()->get( array( 'id' => $element->ID ) );
				$risk = $risk[0];
				if ( !empty( $risk->taxonomy['digi-method'][0] ) && $risk->taxonomy['digi-method'][0] == $term_method_evarisk_id ) {
					$list_risk[] = $risk;
				}
		  }
		}

		// On récupère le risque évaluation de chaque risque
		if ( !empty( $list_risk ) ) {
		  foreach ( $list_risk as $element ) {
				$risk_evaluation = risk_evaluation_class::g()->get( array( 'id' => $element->current_evaluation_id ) );
				$risk_evaluation = $risk_evaluation[0];
				// On modifie les anciennes variables avec les nouvelles
				if ( !empty( $risk_evaluation->quotation_detail ) ) {
				  foreach ( $risk_evaluation->quotation_detail as $e_key => $element ) {
						if ( !empty( $risk_evaluation->quotation_detail[$e_key]['variable_id'] ) ) {
							$risk_evaluation->quotation_detail[$e_key]['variable_id'] = $list_new_variable_id[$e_key];
						}
				  }
				}

				risk_evaluation_class::g()->update( $risk_evaluation );
		  }
		}
	}
}

tools_class::g();
