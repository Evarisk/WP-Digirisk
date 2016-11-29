<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class workunit_class extends post_class {
	public $element_prefix = 'UT';
	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );
	protected $model_name   = '\digi\workunit_model';
	protected $post_type    = 'digi-workunit';
	protected $meta_key    	= '_wp_workunit';
	protected $base = 'digirisk/workunit';
	protected $version = '0.1';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Unitée de travail';

	protected function construct() {
		parent::construct();
		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for societies management	*/

		/**	Create shortcodes for elements displaying	*/
		/**	Shortcode for displaying a dropdown with all groups	*/
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}
}

workunit_class::g();
