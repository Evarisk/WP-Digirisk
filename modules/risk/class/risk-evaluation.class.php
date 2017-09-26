<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class Risk_Evaluation_Class extends \eoxia\Comment_Class {
	protected $model_name   = '\digi\risk_evaluation_model';
	protected $meta_key     = '_wpdigi_risk_evaluation';
	protected $comment_type	= 'digi-risk-eval';
	protected $base = 'risk_evaluation';

	public $element_prefix 	= 'E';
	protected $before_model_post_function = array( '\digi\construct_evaluation' );
	protected $before_model_put_function = array( '\digi\construct_evaluation' );
	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );

	protected function construct() {
		parent::construct();
	}

}

Risk_Evaluation_Class::g();
