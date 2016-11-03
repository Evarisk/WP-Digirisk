<?php namespace digi;
/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package evaluation_method
* @subpackage class
*/

if ( !defined( 'ABSPATH' ) ) exit;

class evaluation_method_class extends term_class {
	protected $model_name   = '\digi\evaluation_method_model';
	protected $taxonomy    	= 'digi-method';
	protected $meta_key    	= '_wpdigi_method';

	protected $base 				= 'digirisk/evaluation-method';
	protected $version 			= '0.1';
	
	public $element_prefix 	= 'ME';
	protected $after_get_function = array( '\digi\get_identifier' );

	public $list_scale = array(
		1 => 0,
		2 => 48,
		3 => 51,
		4 => 80
	);

	/**
	* Le constructeur
	*/
	protected function construct() {
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	* Créer une méthode d'évaluation
	*
	* @param array $data Les données pour créer la méthode d'évaluation
	*
	* @return object L'objet créé
	*/
	public function create_evaluation_method( $data ) {
		$evaluation_method = $this->create( $data );

		if ( is_wp_error( $evaluation_method ) && !empty( $evaluation_method->errors ) && !empty( $evaluation_method->errors['term_exists'] ) ) {
			$evaluation_method = $this->show( $evaluation_method->error_data['term_exists'] );
		}

		return $evaluation_method;
	}

}

evaluation_method_class::g();
