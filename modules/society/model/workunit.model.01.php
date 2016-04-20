<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal de l'extension digirisk pour wordpress / Main controller file for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal de l'extension digirisk pour wordpress / Main controller class for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_workunit_mdl_01 extends post_mdl_01 {

	/**
	 * Définition du modèle d'une unité de travail / Define a work unit model
	 *
	 * @var array
	 */
	protected $array_option = array(
		'associated_document_id' => array(
			'type' 		=> 'array',
			'function'	=> '',
			'default'	=> null,
			'required'	=> false,
		),
		'user_info' => array(
			'owner_id' => array(
				'type' 		=> 'integer',
				'function'	=> '',
				'default'	=> 0,
				'required'	=> false,
			),
			'affected_id' => array(
				'type' 		=> 'array',
				'function'	=> '',
				'default'	=> array(),
				'required'	=> false,
			),
		),
		'contact' => array(
			'phone' => array(
				'type'		=> 'array',
				'function'	=> '',
				'default'	=> array(),
				'required'	=> false,
			),
			'address' => array(
				'type'		=> 'array',
				'function'	=> '',
				'default'	=>array(),
				'required'	=> false,
			),
		),
		'identity' => array(
			'workforce' => array(
				'type'		=> 'integer',
				'function'	=> '',
				'default'	=> array(),
				'required'	=> false,
			),
		),
		'associated_risk' => array(
				'type'		=> 'array',
				'function'	=> '',
				'default'	=> null,
				'required'	=> false,
		),
		'associated_product' => array(
				'type'		=> 'array',
				'function'	=> '',
				'default'	=> null,
				'required'	=> false,
		),
		'associated_recommendation' => array(
			'type' 		=> 'array',
			'function'	=> '',
			'default'	=> null,
			'required'	=> false,
		),
	);

	/**
	 * Construit le modèle d'une unité de travail / Fill the work unit model
	 *
	 * @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	 * @param string $meta_key Le nom de la metakey utilisée pour le rangement des données associées à l'élément / The main metakey used to store data associated to current object
	 * @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	 */
	public function __construct( $object, $meta_key, $cropped = false ) {
		$this->array_option[ 'unique_key' ] = array(
			'type' 		=> 'string',
			'field_type'		=> 'meta',
			'field'		=> '_wpdigi_unique_key',
			'function'	=> '',
			'default'	=> 0,
			'required'	=> true,
		);
		$this->array_option[ 'unique_identifier' ] = array(
			'type' 		=> 'string',
			'field_type'		=> 'meta',
			'field'		=> '_wpdigi_unique_identifier',
			'function'	=> '',
			'default'	=> 0,
			'required'	=> true,
		);

		parent::__construct( $object, $meta_key, $cropped );
	}

}
