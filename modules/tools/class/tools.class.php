<?php if ( !defined( 'ABSPATH' ) ) exit;

class tools_class extends singleton_util {

	protected function construct() { }

  public function add_variable( $method_evaluation, $variable ) {
    $unique_key = wpdigi_utils::get_last_unique_key( 'term', evaluation_method_variable_class::get()->get_taxonomy() );
    $unique_key++;
    $unique_identifier = ELEMENT_IDENTIFIER_ME . '' . $unique_key;

    // On tente de crée les variables de la méthode d'évaluation
    $evaluation_method_variable = evaluation_method_variable_class::get()->create( array(
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

      $method_evaluation = evaluation_method_class::get()->update( $method_evaluation );
    }

		return $evaluation_method_variable->id;
  }

	public function fix_all_risk( $term_method_evarisk_id, $list_old_variable_id, $list_new_variable_id ) {
		global $wpdb;
		$list_risk = array();
		$list_risk_evaluation = array();

		// On récupère les risques
		$query = "SELECT ID FROM {$wpdb->posts} WHERE post_type=%s";
		$list_post = $wpdb->get_results( $wpdb->prepare( $query, array( risk_class::get()->get_post_type() ) ) );

		if ( !empty( $list_post ) ) {
		  foreach ( $list_post as $element ) {
				$risk = risk_class::get()->show( $element->ID );
				if ( $risk->taxonomy['digi-method'][0] == $term_method_evarisk_id ) {
					$list_risk[] = $risk;
				}
		  }
		}

		// On récupère le risque évaluation de chaque risque
		if ( !empty( $list_risk ) ) {
		  foreach ( $list_risk as $element ) {
				$risk_evaluation = risk_evaluation_class::get()->show( $element->option['current_evaluation_id'] );
				// On modifie les anciennes variables avec les nouvelles
				if ( !empty( $risk_evaluation->option['quotation_detail'] ) ) {
				  foreach ( $risk_evaluation->option['quotation_detail'] as $e_key => $element ) {
						$risk_evaluation->option['quotation_detail'][$e_key]['variable_id'] = $list_new_variable_id[$e_key];
				  }
				}

				risk_evaluation_class::get()->update( $risk_evaluation );
		  }
		}
	}
}

tools_class::get();
