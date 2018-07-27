<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class Risk_Evaluation_Comment_Class extends \eoxia001\comment_class {

	protected $model_name   = '\digi\risk_evaluation_comment_model';
	protected $meta_key     = '_wpdigi_risk_evaluation_comment';
	protected $comment_type	= 'digi-riskevalcomment';

	protected $base					= 'risk-evaluation-comment';
	protected $version			= '0.1';

	protected function construct() {
		parent::construct();
	}

}

Risk_Evaluation_Comment_Class::g();
