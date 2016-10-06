<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class term_attachment_class extends term_class {
	protected $model_name = '\digi\term_model';
	protected $meta_key = '_wpeo_term';
	protected $taxonomy = 'attachment_category';
	protected $base = 'term';
	protected $version = '0.1';
	protected $identifier_helper = 'term';

	protected function construct() {}
}
