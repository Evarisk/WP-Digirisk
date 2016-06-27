<?php if ( !defined( 'ABSPATH' ) ) exit;

class wpdigi_tools_ctr {

	function __construct() {
	    add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'wp_ajax_reset_method_evaluation', array( $this, 'callback_reset_method_evaluation' ) );
		add_action( 'wp_ajax_compil_risk_list', array( $this, 'callback_risk_compilation' ) );
	}

  public function admin_menu() {
    add_management_page( 'Digirisk', 'Digirisk', 'manage_options', 'digirisk-tools', array( $this, 'add_management_page' ) );
  }

  public function add_management_page() {
    require( TOOLS_TEMPLATES_MAIN_DIR . '/main.php' );
  }

  public function callback_reset_method_evaluation() {
    check_ajax_referer( 'reset_method_evaluation' );

    global $wpdigi_evaluation_method_controller;
    global $wpdigi_evaluation_method_variable_controller;

    // Récupères la méthode d'évaluation
    $term_method_evarisk = get_term_by( 'slug', 'evarisk', $wpdigi_evaluation_method_controller->get_taxonomy() );
    $method_evaluation = $wpdigi_evaluation_method_controller->show( $term_method_evarisk->term_id );

		$list_old_variable_id = array();
		$list_new_variable_id = array();

    // Suppresion de toutes les variables actuelles.
    if ( !empty( $method_evaluation->option['formula'] ) ) {
      foreach ( $method_evaluation->option['formula'] as $element ) {
        if ( $element != '*' ) {
          $wpdigi_evaluation_method_variable_controller->delete( (int) $element ); // Ne supprimes pas le term ? bug

					if ( !in_array( (int) $element, $list_old_variable_id ) ) {
						$list_old_variable_id[] = (int)$element;
					}
        }
      }
    }

    // Suppresion également des variables par leurs noms ( Au cas ou certains sont passé à coté de la première suppression )
    $array_slug = array( 'Gravite', 'Exposition', 'Occurence', 'Formation', 'Protection' );
    foreach ( $array_slug as $element ) {
      $term = get_term_by( 'name', $element, $wpdigi_evaluation_method_variable_controller->get_taxonomy() );
      if ( !empty( $term ) && ( $term->term_id ) ) {
        // $wpdigi_evaluation_method_variable_controller->delete( $term->term_id ); Ne supprimes pas le term ? bug
        wp_delete_term( $term->term_id, $wpdigi_evaluation_method_variable_controller->get_taxonomy() );

				if ( !in_array( $term->term_id, $list_old_variable_id ) ) {
					$list_old_variable_id[] = $term->term_id;
				}
      }
    }

    // On met à jours la méthode d'évaluation pour enlever les formules
    unset( $method_evaluation->option['formula'] );
    $method_evaluation = $wpdigi_evaluation_method_controller->update( $method_evaluation );

    // Ajout des nouvelles variables
    $file_content = file_get_contents( WPDIGI_EVALMETHOD_PATH . 'asset/json/default.json' );
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
      $term_id = $this->add_variable( $method_evaluation, $element );

			if ( !in_array( $term_id, $list_new_variable_id ) ) {
				$list_new_variable_id[] = $term_id;
			}
    }

		$this->fix_all_risk( $term_method_evarisk->term_id, $list_old_variable_id, $list_new_variable_id);

    wp_send_json_success();
  }

  public function add_variable( $method_evaluation, $variable ) {
    global $wpdigi_evaluation_method_controller;
    global $wpdigi_evaluation_method_variable_controller;

    $unique_key = wpdigi_utils::get_last_unique_key( 'term', $wpdigi_evaluation_method_variable_controller->get_taxonomy() );
    $unique_key++;
    $unique_identifier = ELEMENT_IDENTIFIER_ME . '' . $unique_key;

    // On tente de crée les variables de la méthode d'évaluation
    $evaluation_method_variable = $wpdigi_evaluation_method_variable_controller->create( array(
        'name' => $variable->name,
        'description' => $variable->description,
        'option' => array(
          'unique_key' => $unique_key,
          'unique_identifier' => $unique_identifier,
          'display_type' => $variable->option->display_type,
          'range' => $variable->option->range,
          'survey' => $variable->option->survey,
        ),
    ) );

    if ( !is_wp_error( $evaluation_method_variable ) ) {
      $method_evaluation->option['formula'][] = $evaluation_method_variable->id;
      $method_evaluation->option['formula'][] = "*";

      $method_evaluation = $wpdigi_evaluation_method_controller->update( $method_evaluation );
    }

		return $evaluation_method_variable->id;
  }

	public function fix_all_risk( $term_method_evarisk_id, $list_old_variable_id, $list_new_variable_id ) {
		global $wpdb;
		global $wpdigi_risk_ctr;
		global $wpdigi_risk_evaluation_ctr;
		$list_risk = array();
		$list_risk_evaluation = array();

		// On récupère les risques
		$query = "SELECT ID FROM {$wpdb->posts} WHERE post_type=%s";
		$list_post = $wpdb->get_results( $wpdb->prepare( $query, array( $wpdigi_risk_ctr->get_post_type() ) ) );

		if ( !empty( $list_post ) ) {
		  foreach ( $list_post as $element ) {
				$risk = $wpdigi_risk_ctr->show( $element->ID );
				if ( $risk->taxonomy['digi-method'][0] == $term_method_evarisk_id ) {
					$list_risk[] = $risk;
				}
		  }
		}

		// On récupère le risque évaluation de chaque risque
		if ( !empty( $list_risk ) ) {
		  foreach ( $list_risk as $element ) {
				$risk_evaluation = $wpdigi_risk_evaluation_ctr->show( $element->option['current_evaluation_id'] );
				// On modifie les anciennes variables avec les nouvelles
				if ( !empty( $risk_evaluation->option['quotation_detail'] ) ) {
				  foreach ( $risk_evaluation->option['quotation_detail'] as $e_key => $element ) {
						$risk_evaluation->option['quotation_detail'][$e_key]['variable_id'] = $list_new_variable_id[$e_key];
				  }
				}

				$wpdigi_risk_evaluation_ctr->update( $risk_evaluation );
		  }
		}
	}

	/**
	 * Callback function for fixing risk list in element when some errors are detected / Fonction de rappel pour la correction de la liste des risques dans les éléments
	 */
	public function callback_risk_compilation() {
		check_ajax_referer( 'risk_list_compil' );
		global $wpdigi_risk_ctr, $wpdigi_group_ctr, $wpdigi_workunit_ctr;

		/**	First let's list all group / Commençons par lister les groupements	*/
		$group_list = $wpdigi_group_ctr->index( array() );
		foreach ( $group_list as $group ) {
			$risk_list = $wpdigi_risk_ctr->get_risk_list_for_element( $group );
			if ( !empty( $risk_list ) ) {
				foreach ( $risk_list as $risk ) {
					$group->option[ 'associated_risk' ][] = $risk->id;
				}

				$wpdigi_group_ctr->update( $group );
			}
		}

		/**	Let's list all workunit / Listons les unités de travail */
		$workunit_list = $wpdigi_workunit_ctr->index( array() );
		foreach ( $workunit_list as $workunit ) {
			$risk_list = $wpdigi_risk_ctr->get_risk_list_for_element( $workunit );
			if ( !empty( $risk_list ) ) {
				foreach ( $risk_list as $risk ) {
					$workunit->option[ 'associated_risk' ][] = $risk->id;
				}

				$wpdigi_workunit_ctr->update( $workunit );
			}
		}

		wp_send_json_success();
	}

}

global $wpdigi_tools_ctr;
$wpdigi_tools_ctr = new wpdigi_tools_ctr();
