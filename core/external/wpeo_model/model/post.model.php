<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class post_model extends constructor_data_class {

	protected $model = array(
		'id' => array(
			'type'	=> 'integer',
			'field'	=> 'ID',
		),
		'parent_id' => array(
			'type'	=> 'integer',
			'field'	=> 'post_parent',
		),
		'author_id' => array(
			'type'	=> 'integer',
			'field'	=> 'post_author',
		),
		'date' => array(
			'type'	=> 'string',
			'field'	=> 'post_date',
		),
		'date_modified' => array(
			'type'	=> 'string',
			'field'	=> 'post_modified',
		),
		'title' 	=> array(
			'type'			=> 'string',
			'field'			=> 'post_title',
			'export'		=> true,
		),
		'slug' 	=> array(
			'type'		=> 'string',
			'field'		=> 'post_name',
			'export'	=> true,
		),
		'content' => array(
			'export' => true,
			'type'	=> 'string',
			'field'	=> 'post_content',
		),
		'status' => array(
			'type'	=> 'string',
			'field'	=> 'post_status',
			'bydefault' => 'publish',
		),
		'link' => array(
			'type'	=> 'string',
			'field'	=> 'guid',
			'export' => true,
		),
		'type' 	=> array(
			'type'	=> 'string',
			'field'	=> 'post_type',
		),
		'order' => array(
			'type' => 'int',
			'field' => 'menu_order',
		),
		'comment_status' 	=> array(
			'type'	=> 'string',
			'field'	=> 'comment_status',
		),
		'comment_count' => array(
			'type'	=> 'int',
			'field'	=> 'comment_count',
		),
		'thumbnail_id' => array(
			'type'				=> 'int',
			'meta_type'		=> 'single',
			'field'				=> '_thumbnail_id',
		)
	);

	/**
	 * Construction de l'objet "custom post type" par remplissage du modèle / Build "custom post type" through fill in the model
	 *
	 * @param object $object L'object avec lequel il faut construire le modèle / The object which one to build
	 * @param string $meta_key Le nom de la "meta" contenant la définition complète de l'object sous forme json / The "meta" name containing the complete definition of object under json format
	 * @param boolean $cropped Permet de choisir si on construit le modèle complet ou uniquement les champs principaux / Allows to choose if the entire model have to be build or only main model
	 */
	public function __construct( $data, $wanted_field = array(), $args = array() ) {
		/**	Instanciation du constructeur de modèle principal / Instanciate the main model constructor	*/
		parent::__construct( $data, $wanted_field, $args );
	}

}
