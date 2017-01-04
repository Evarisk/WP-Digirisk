<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class Risk_Evaluation_Class extends Comment_Class {
	protected $model_name   = '\digi\risk_evaluation_model';
	protected $meta_key     = '_wpdigi_risk_evaluation';
	protected $comment_type	= 'digi-risk-eval';

	protected $base 				= 'digirisk/risk-evaluation';
	protected $version 			= '0.1';

	public $element_prefix 	= 'E';
	protected $before_model_post_function = array( '\digi\construct_evaluation' );
	protected $before_model_put_function = array( '\digi\construct_evaluation' );
	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );

	protected function construct() {
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

}

Risk_Evaluation_Class::g();
