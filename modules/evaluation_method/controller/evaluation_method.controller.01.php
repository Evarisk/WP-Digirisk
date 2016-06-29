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

class evaluation_method_class extends term_ctr_01 {
	protected $model_name   = 'wpdigi_evaluation_method_mdl_01';
	protected $taxonomy    	= 'digi-method';
	protected $meta_key    	= '_wpdigi_method';
	protected $base = 'digirisk/evaluation-method';
	protected $version = '0.1';

	public $list_scale = array(
		1 => 0,
		2 => 48,
		3 => 51,
		4 => 80
	);

	public function __construct() {
		parent::__construct();
		/**	Inclusion du modèle / Include model	*/
		include_once( WPDIGI_EVALMETHOD_PATH . 'model/evaluation_method.model.01.php' );

		add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts' ) );
	}

	public function callback_admin_enqueue_scripts() {
		wp_enqueue_script( 'wpdigi-evaluation-method-backend-js', WPDIGI_EVALMETHOD_URL . 'asset/js/evaluation_method.backend.js', array( 'jquery', 'jquery-form', 'jquery-ui-datepicker', 'jquery-ui-autocomplete', 'suggest' ), WPDIGI_VERSION, false );
	}

	public function create_evaluation_method( $data ) {
		$evaluation_method = $this->create( $data );

		if ( is_wp_error( $evaluation_method ) && !empty( $evaluation_method->errors ) && !empty( $evaluation_method->errors['term_exists'] ) ) {
			$evaluation_method = $this->show( $evaluation_method->error_data['term_exists'] );
		}

		return $evaluation_method;
	}

	public function create_default_data() {
		global $wpdigi_evaluation_method_variable_controller;

		$file_content = file_get_contents( WPDIGI_EVALMETHOD_PATH . 'asset/json/default.json' );
		$data = json_decode( $file_content );

		if ( !empty( $data ) ) {
			foreach ( $data as $json_evaluation_method ) {

				$unique_key = wpdigi_utils::get_last_unique_key( 'term', $this->get_taxonomy() );
				$unique_key++;
				$unique_identifier = ELEMENT_IDENTIFIER_ME . '' . $unique_key;
				$evaluation_method = $this->create( array(
						'name' => $json_evaluation_method->name,
						'option' => array(
							'unique_key' => $unique_key,
							'unique_identifier' => $unique_identifier,
							'is_default'		=> $json_evaluation_method->option->is_default,
							'matrix'			=> $json_evaluation_method->option->matrix,
						),
				) );

				if ( is_wp_error( $evaluation_method ) && !empty( $evaluation_method->errors ) && !empty( $evaluation_method->errors['term_exists'] ) ) {
					$evaluation_method = $this->show( $evaluation_method->error_data['term_exists'] );
				}

				foreach( $json_evaluation_method->option->variable as $json_evaluation_method_variable ) {
					$unique_key = wpdigi_utils::get_last_unique_key( 'term', $wpdigi_evaluation_method_variable_controller->get_taxonomy() );
					$unique_key++;
					$unique_identifier = ELEMENT_IDENTIFIER_ME . '' . $unique_key;

					// On tente de crée les variables de la méthode d'évaluation
					$evaluation_method_variable = $wpdigi_evaluation_method_variable_controller->create( array(
							'name' => $json_evaluation_method_variable->name,
							'description' => $json_evaluation_method_variable->description,
							'option' => array(
								'unique_key' => $unique_key,
								'unique_identifier' => $unique_identifier,
								'display_type' => $json_evaluation_method_variable->option->display_type,
								'range' => $json_evaluation_method_variable->option->range,
								'survey' => $json_evaluation_method_variable->option->survey,
							),
					) );

					// Si elle existe déjà
					if ( !is_wp_error( $evaluation_method_variable ) ) {
						if ( $json_evaluation_method->name == 'Evarisk' ) {
							$evaluation_method->option['formula'][] = $evaluation_method_variable->id;
							$evaluation_method->option['formula'][] = "*";
						}
						else {
							if ( !empty( $evaluation_method_variable->id ) )
								$evaluation_method->option['formula'][] = $evaluation_method_variable->id;
						}

						$evaluation_method = $this->update( $evaluation_method );
					}
				}
			}
		}
	}
}

global $evaluation_method_class;
$evaluation_method_class = new evaluation_method_class();
