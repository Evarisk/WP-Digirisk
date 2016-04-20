<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier de gestion des modèles pour les catégories de dangers dans Digirisk / Danger categories management file for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe de gestion des modèles pour les catégories de dangers dans Digirisk / Danger categories management class for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_category_danger_mdl_01 extends term_mdl_01 {

	/**
	 * Définition du modèle d'une catégorie de danger / Define a danger category model
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
			'field_type'		=> 'meta',
			'field'		=> '_wpdigi_unique_identifer',
			'function'	=> '',
			'default'	=> 0,
			'required'	=> true,
		),
		'position' => array(
			'type' 		=> 'integer',
			'function'	=> '',
			'default'	=> 0,
			'required'	=> false,
		),
		'thumbnail_id' => array(
			'type' 		=> 'integer',
			'field_type'		=> 'meta',
			'field'		=> '_thumbnail_id',
			'function'	=> '',
			'default'	=> 0,
			'required'	=> false,
		),
		'associated_document_id' => array(
			'type' 		=> 'array',
			'function'	=> '',
			'default'	=> null,
			'required'	=> false,
		),
	);

	/**
	 * Construit le modèle de catégorie de danger / Fill the danger category model
	 *
	 * @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	 * @param string $meta_key Le nom de la metakey utilisée pour le rangement des données associées à l'élément / The main metakey used to store data associated to current object
	 * @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	 */
	public function __construct( $object, $meta_key, $cropped = false ) {
		parent::__construct( $object, $meta_key, $cropped );
	}

}
