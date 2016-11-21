<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class term_model extends constructor_data_class {

	/**
	 * Définition du modèle principal des taxinomies / Main definition for taxonomy model
	 * @var array Les champs principaux d'une taxinomie / Main fields for a taxonomy
	 */
	protected $model = array(
		'id' => array(
			'type'		=> 'integer',
			'field'		=> 'term_id',
			'bydefault'	=> 0,
		),
		'type' => array(
			'type'		=> 'string',
			'field'		=> 'taxonomy',
			'bydefault'	=> 0,
		),
		'term_taxonomy_id' => array(
			'type'		=> 'integer',
			'field'		=> 'term_taxonomy_id',
			'bydefault'	=> 0,
		),
		'name' => array(
			'type'		=> 'string',
			'field'		=> 'name',
			'bydefault'	=> 0,
			'export'	=> true,
		),
		'description' => array(
			'type'		=> 'string',
			'field'		=> 'description',
			'bydefault'	=> 0,
		),
		'slug' => array(
			'export'	=> true,
			'type'		=> 'string',
			'field'		=> 'slug',
			'bydefault'	=> 0
		),
		'parent_id' => array(
			'export' 	=> true,
			'type'		=> 'integer',
			'field'		=> 'parent',
			'bydefault'	=> 0,
		),
		'post_id' => array(
			'type' 	=> 'integer',
			'field'	=>	'post_id',
			'bydefault' => 0,
		)
	);

	public function __construct( $object, $children_wanted = array(), $args = array() ) {
		/**	Instanciation du constructeur de modèle principal / Instanciate the main model constructor	*/
		parent::__construct( $object, $children_wanted, $args );
	}

}
