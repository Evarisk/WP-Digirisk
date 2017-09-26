<?php namespace digi;

if ( ! defined( 'ABSPATH' ) ) exit;

class Workunit_Class extends \eoxia\post_class {
	public $element_prefix = 'UT';
	protected $before_post_function = array( '\digi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement avant la modification de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_put_function = array();

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier' );
	protected $model_name   = '\digi\workunit_model';
	protected $post_type    = 'digi-workunit';
	protected $meta_key    	= '_wp_workunit';
	protected $base = 'workunit';
	protected $version = '0.1';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Unitée de travail';

	protected function construct() {
		parent::construct();
	}
}

workunit_class::g();
