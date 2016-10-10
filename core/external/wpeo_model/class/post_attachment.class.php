<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class attachment_class extends post_class {
	protected $model_name = '\digi\post_model';
	protected $post_type = 'attachment';
	protected $meta_key = '_wpeo_attachment';
	protected $version = '0.1.0.0';

	protected function construct() {}
}
