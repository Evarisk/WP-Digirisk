<?php
/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package evaluation_method
* @subpackage class
*/

if ( !defined( 'ABSPATH' ) ) exit;

class evaluation_method_default_data_class extends singleton_util {
	protected function construct() {}

	/**
	* Créer les méthodes d'évaluation par défaut
	*/
	public function create() {
		$file_content = file_get_contents( EVALUATION_METHOD_PATH . 'asset/json/default.json' );
		$data = json_decode( $file_content );

		if ( !empty( $data ) ) {
			foreach ( $data as $json_evaluation_method ) {
				$this->create_evaluation_method( $json_evaluation_method );
			}
		}
	}

	private function create_evaluation_method( $json_evaluation_method ) {
		$evaluation_method = evaluation_method_class::g()->create( array(
		'name' 				=> $json_evaluation_method->name,
		'is_default'	=> $json_evaluation_method->option->is_default,
		'matrix'			=> $json_evaluation_method->option->matrix,
		) );

		if ( is_wp_error( $evaluation_method ) && !empty( $evaluation_method->errors ) && !empty( $evaluation_method->errors['term_exists'] ) ) {
			$evaluation_method = evaluation_method_class::g()->get( array( 'id' => $evaluation_method->error_data['term_exists'] ) );
		}

		foreach( $json_evaluation_method->option->variable as $json_evaluation_method_variable ) {
			$this->create_evaluation_method_variable( $evaluation_method, $json_evaluation_method, $json_evaluation_method_variable );
		}
	}

	private function create_evaluation_method_variable( $evaluation_method, $json_evaluation_method, $json_evaluation_method_variable ) {
		// On tente de crée les variables de la méthode d'évaluation
		$evaluation_method_variable = evaluation_method_variable_class::g()->create( array(
				'name' => $json_evaluation_method_variable->name,
				'description' => $json_evaluation_method_variable->description,
				'display_type' => $json_evaluation_method_variable->option->display_type,
				'range' => $json_evaluation_method_variable->option->range,
				'survey' => $json_evaluation_method_variable->option->survey,
		) );

		// Si elle existe déjà
		if ( !is_wp_error( $evaluation_method_variable ) ) {
			if ( $json_evaluation_method->name == 'Evarisk' ) {
				$evaluation_method->formula[] = $evaluation_method_variable->id;
				$evaluation_method->formula[] = "*";
			}
			else {
				if ( !empty( $evaluation_method_variable->id ) )
					$evaluation_method->formula[] = $evaluation_method_variable->id;
			}

			$evaluation_method = evaluation_method_class::g()->update( $evaluation_method );
		}
	}
}
