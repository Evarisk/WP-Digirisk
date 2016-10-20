<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class recommendation_comment_class extends comment_class {

	protected $model_name   = '\digi\recommendation_comment_model';
	protected $meta_key     = '_wpdigi_recommendation_comment';
	protected $comment_type	= 'digi-re-comment';

	protected $base					= 'digirisk/recommendation-comment';
	protected $version			= '0.1';

	protected function construct() {
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

}

recommendation_comment_class::g();
