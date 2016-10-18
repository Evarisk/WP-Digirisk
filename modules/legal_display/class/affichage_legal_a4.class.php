<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal pour les catégories de documents dans Digirisk / Controller file for attachment categories for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal pour les catégories de documents dans Digirisk / Controller class for attachment categories for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class affichage_legal_a4_class extends post_class {
	protected $model_name   				= '\digi\affichage_legal_a4_model';
	protected $post_type    				= 'attachment';
	public $attached_taxonomy_type  = 'attachment_category';
	protected $meta_key    					= '_wpdigi_document';

	protected $base 								= 'digirisk/affichage_legal_a4';
	protected $version 							= '0.1';

	public $element_prefix 					= 'DOC';
	protected $before_put_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );

	protected function construct() {
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}
}
