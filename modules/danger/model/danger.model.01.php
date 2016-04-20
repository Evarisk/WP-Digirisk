<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier de gestion des modèles pour les dangers dans Digirisk / Danger management file for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe de gestion des modèles pour les dangers dans Digirisk / Danger management class for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_danger_mdl_01 extends term_mdl_01 {

	/**
	 * Définition du modèle d'un danger / Define a danger model
	 *
	 * @var array
	 */
	protected $array_option = array(
		'status' => array(
			'type' 				=> 'string',
			'field_type'	=> 'meta',
			'field'				=> '_wpdigi_status',
			'function'		=> '',
			'default'			=> 0,
			'required'		=> false,
		),
		'unique_key' => array(
			'type' 		=> 'string',
			'field_type'		=> 'meta',
			'field'		=> '_wpdigi_unique_key',
			'function'	=> '',
			'default'	=> 0,
			'required'	=> true,
		),
		'unique_identifier' => array(
			'type' 		=> 'string',
			'function'	=> '',
			'default'	=> 0,
			'required'	=> true,
		),
		'thumbnail_id' => array(
			'type' 		=> 'integer',
			'field_type'		=> 'meta',
			'field'		=> '_thumbnail_id',
			'function'	=> '',
			'default'	=> 0,
			'required'	=> false,
		),
		'default_method' => array(
			'type' 		=> 'integer',
			'function'	=> '',
			'default'	=> 0,
			'required'	=> false,
		),
		'default_of_category' => array(
			'type' 		=> 'boolean',
			'function'	=> '',
			'default'	=> false,
			'required'	=> false,
		),
		'is_annoying' => array(
			'type' 		=> 'boolean',
			'function'	=> '',
			'default'	=> false,
			'required'	=> false,
		),
	);

	/**
	 * Construit le modèle de danger / Fill the danger model
	 *
	 * @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	 * @param string $meta_key Le nom de la metakey utilisée pour le rangement des données associées à l'élément / The main metakey used to store data associated to current object
	 * @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	 */
	public function __construct( $object, $meta_key, $cropped = false ) {
		parent::__construct( $object, $meta_key, $cropped );
	}

}
