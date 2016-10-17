<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class fiche_de_poste_class extends document_class {

	protected $model_name   				= '\digi\fiche_de_poste_model';
	protected $post_type    				= 'attachment';
	public $attached_taxonomy_type  = 'attachment_category';
	protected $meta_key    					= '_wpdigi_document';
	protected $base 								= 'digirisk/fiche-de-poste';
	protected $version 							= '0.1';
	public $element_prefix 					= 'DOC';
	protected $before_put_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );

	protected function construct() {
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

}
