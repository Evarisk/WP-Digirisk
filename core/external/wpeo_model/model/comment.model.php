<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class comment_model extends constructor_data_class {

	/**
	 * Définition du modèle principal des commentaires / Main definition for comment model
	 * @var array Les champs principaux des commentaires / Main fields for a comment
	 */
	protected $model = array(
		'id' => array(
			'type'		=> 'integer',
			'field'		=> 'comment_ID',
		),
		'parent_id' => array(
			'type'		=> 'integer',
			'field'		=> 'comment_parent',
		),
		'post_id' => array(
			'type'		=> 'integer',
			'field'		=> 'comment_post_ID',
		),
		'date' => array(
			'export'	=> true,
			'type'		=> 'string',
			'field'		=> 'comment_date',
		),
		'author_id' => array(
			'type'		=> 'integer',
			'field'		=> 'user_id',
		),
		'author_nicename' => array(
			'type'		=> 'string',
			'field'		=> 'comment_author',
		),
		'author_email' => array(
			'type'		=> 'string',
			'field'		=> 'comment_author_email',
		),
		'author_ip' => array(
			'type'		=> 'string',
			'field'		=> 'comment_author_IP',
		),
		'content' => array(
			'export'	=> true,
			'type'		=> 'string',
			'field'		=> 'comment_content'
		),
		'status' => array(
			'export'	=> true,
			'type'		=> 'string',
			'field'		=> 'comment_approved',
		),
		'type' => array(
			'type'		=> 'string',
			'field'		=> 'comment_type',
		),
	);

	/**
	 * Construction de l'objet commentaire par remplissage du modèle / Build comment through fill in the model
	 *
	 * @param object $object L'object avec lequel il faut construire le modèle / The object which one to build
	 * @param string $meta_key Le nom de la "meta" contenant la définition complète de l'object sous forme json / The "meta" name containing the complete definition of object under json format
	 * @param boolean $cropped Permet de choisir si on construit le modèle complet ou uniquement les champs principaux / Allows to choose if the entire model have to be build or only main model
	 */
	public function __construct( $data, $field_wanted = array(), $args = array() ) {
		parent::__construct( $data, $field_wanted, $args );
	}

}
