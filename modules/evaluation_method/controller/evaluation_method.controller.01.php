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
	}

	public function create_evaluation_method( $data ) {
		$evaluation_method = $this->create( $data );

		if ( is_wp_error( $evaluation_method ) && !empty( $evaluation_method->errors ) && !empty( $evaluation_method->errors['term_exists'] ) ) {
			$evaluation_method = $this->show( $evaluation_method->error_data['term_exists'] );
		}

		return $evaluation_method;
	}
}

global $evaluation_method_class;
$evaluation_method_class = new evaluation_method_class();
