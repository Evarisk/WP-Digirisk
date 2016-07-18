<?php if ( !defined( 'ABSPATH' ) ) exit;

class risk_evaluation_class extends comment_class {
	protected $model_name   = 'wpdigi_riskevaluation_mdl_01';
	protected $meta_key     = '_wpdigi_risk_evaluation';
	protected $comment_type	= 'digi-risk-eval';
	protected $base 				= 'digirisk/risk-evaluation';
	protected $version 			= '0.1';
	public $element_prefix 	= 'E';

	protected function construct() {}

}
