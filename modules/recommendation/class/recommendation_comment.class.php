<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class recommendation_comment_class extends \eoxia001\comment_class {

	protected $model_name   = '\digi\recommendation_comment_model';
	protected $meta_key     = '_wpdigi_recommendation_comment';
	protected $comment_type	= 'digi-re-comment';

	protected $base					= 'recommendation-comment';
	protected $version			= '0.1';

	protected function construct() {
		parent::construct();
	}

}

recommendation_comment_class::g();
