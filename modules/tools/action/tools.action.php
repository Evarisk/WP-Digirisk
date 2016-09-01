<?php if ( !defined( 'ABSPATH' ) ) exit;

class tools_action {

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
    $file_content = file_get_contents( EVALUATION_METHOD_PATH . 'asset/json/default.json' );
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

    wp_send_json_success();
  }

	/**
	 * Callback function for fixing risk list in element when some errors are detected / Fonction de rappel pour la correction de la liste des risques dans les éléments
	 */
	public function callback_risk_compilation() {
		check_ajax_referer( 'risk_list_compil' );

		/**	First let's list all group / Commençons par lister les groupements	*/
		$group_list = group_class::g()->get( array() );
		foreach ( $group_list as $group ) {
			$risk_list = risk_class::g()->get( array( 'post_parent' => $group->id ) );
			if ( !empty( $risk_list ) ) {
				foreach ( $risk_list as $risk ) {
					$group->associated_risk[] = $risk->id;
				}

				group_class::g()->update( $group );
			}
		}

		/**	Let's list all workunit / Listons les unités de travail */
		$workunit_list = workunit_class::g()->get( array() );
		foreach ( $workunit_list as $workunit ) {
			$risk_list = risk_class::g()->get( array( 'post_parent' => $workunit->id ) );
			if ( !empty( $risk_list ) ) {
				foreach ( $risk_list as $risk ) {
					$workunit->associated_risk[] = $risk->id;
				}

				workunit_class::g()->update( $workunit );
			}
		}

		wp_send_json_success();
	}
}

new tools_action();
