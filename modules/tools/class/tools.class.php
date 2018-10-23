<?php namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class tools_class extends \eoxia001\Singleton_Util {

	protected function construct() { }

	public function reset_method_evaluation() {
		// Récupères la méthode d'évaluation
    $term_method_evarisk = get_term_by( 'slug', 'evarisk', evaluation_method_class::g()->get_type() );
    $method_evaluation = evaluation_method_class::g()->get( array( 'id' => $term_method_evarisk->term_id ) );
		$method_evaluation = $method_evaluation[0];

		$list_old_variable_id = array();
		$list_new_variable_id = array();

    // Suppresion de toutes les variables actuelles.
    if ( !empty( $method_evaluation->formula ) ) {
      foreach ( $method_evaluation->formula as $element ) {
        if ( $element != '*' ) {
          wp_delete_term( (int) $element, evaluation_method_class::g()->get_type() );

					if ( !in_array( (int) $element, $list_old_variable_id ) ) {
						$list_old_variable_id[] = (int)$element;
					}
        }
      }
    }

    // Suppresion également des variables par leurs noms ( Au cas ou certains sont passé à coté de la première suppression )
    $array_slug = array( 'Gravite', 'Exposition', 'Occurence', 'Formation', 'Protection' );
    foreach ( $array_slug as $element ) {
      $term = get_term_by( 'name', $element, evaluation_method_variable_class::g()->get_type() );
      if ( !empty( $term ) && ( $term->term_id ) ) {
        // evaluation_method_variable_class::g()->delete( $term->term_id ); Ne supprimes pas le term ? bug
        wp_delete_term( $term->term_id, evaluation_method_variable_class::g()->get_type() );

				if ( !in_array( $term->term_id, $list_old_variable_id ) ) {
					$list_old_variable_id[] = $term->term_id;
				}
      }
    }

		// On met à jours la méthode d'évaluation pour enlever les formules
		$method_evaluation->formula = array();
		$method_evaluation = evaluation_method_class::g()->update( $method_evaluation );

    // Ajout des nouvelles variables
    $file_content = file_get_contents( \eoxia001\Config_Util::$init['digirisk']->evaluation_method->path . 'asset/json/default.json' );
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
			'name'         => $variable->name,
			'description'  => $variable->description,
			'display_type' => $variable->option->display_type,
			'range'        => $variable->option->range,
			'survey'       => (array)$variable->option->survey,
		) );

    if ( !is_wp_error( $evaluation_method_variable ) ) {
      $method_evaluation->formula[] = $evaluation_method_variable->id;
      $method_evaluation->formula[] = '*';
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
		$list_post = $wpdb->get_results( $wpdb->prepare( $query, array( risk_class::g()->get_Type() ) ) );

		if ( !empty( $list_post ) ) {
		  foreach ( $list_post as $element ) {
				$risk = risk_class::g()->get( array( 'id' => $element->ID ), true );
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

	/**
	 * Transfères les identifiants des documents.
	 *
	 * @return void
	 *
	 * @since 6.2.10.0
	 * @version 6.2.10.0
	 */
	public function transfert_doc() {
		$types_to_transfert = array(
			'document_unique' => '\digi\DUER_Class',
			'fiche_de_groupement' => '\digi\Fiche_De_Groupement_Class',
			'fiche_de_poste'			=> '\digi\Fiche_De_Poste_Class',
			'affichage_legal_a4'	=> '\digi\Affichage_Legal_A4_Class',
			'affichage_legal_a3'	=> '\digi\Affichage_Legal_A3_Class',
		);

		if ( ! empty( $types_to_transfert ) ) {
			foreach ( $types_to_transfert as $type => $type_class ) {
				$args = array(
					'post_status' => 'inherit',
					'tax_query' => array(
						array(
							'taxonomy' 	=> Document_Class::g()->attached_taxonomy_type,
							'field'			=> 'slug',
							'terms'			=> $type,
						),
					),
				);

				$list_document = Document_Class::g()->get( $args );

				if ( ! empty( $list_document ) ) {
					foreach ( $list_document as $element ) {
						$element->unique_identifier = str_replace( Document_Class::g()->element_prefix, $type_class::g()->element_prefix, $element->unique_identifier );
						$type_class::g()->update( $element );
					}
				}
			}
		}
	}
}

tools_class::g();
