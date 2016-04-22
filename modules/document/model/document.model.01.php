<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur pour la gestion des risques / Main controller file for risk management
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur pour la gestion des risques / Main class file for risk management
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_document_mdl_01 extends post_mdl_01 {

	/**
	 * Définition du modèle d'un risque / Define a risk model
	 *
	 * @var array
	 */
	protected $array_option = array(
		'unique_key' 	=> array(
			'type' 				=> 'string',
			'field_type'	=> 'meta',
			'field'				=> '_wpdigi_unique_key',
			'function'		=> '',
			'default'			=> 0,
			'required'		=> true,
		),
		'unique_identifier' => array(
			'type' 				=> 'string',
			'field_type'	=> 'meta',
			'field'				=> '_wpdigi_unique_identifier',
			'function'		=> '',
			'default'			=> 0,
			'required'		=> true,
		),
		'model_id' => array(
			'type' 				=> 'integer',
			'field_type'	=> 'meta',
			'field'				=> '_wpdigi_model_id',
			'function'		=> '',
			'default'			=> 0,
			'required'		=> true,
		),
		'document_meta' => array(
			'type' 				=> 'string',
			'field_type'	=> 'meta',
			'field'				=> '_wpdigi_document_data',
			'function'		=> '',
			'default'			=> 0,
			'required'		=> false,
		),
	);

	/**
	 * Construit le modèle / Fill the model
	 *
	 * @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	 * @param string $meta_key Le nom de la metakey utilisée pour le rangement des données associées à l'élément / The main metakey used to store data associated to current object
	 * @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	 */
	public function __construct( $object, $meta_key, $cropped = false ) {
		$array_model = $this->get_model();

		$this->model['mime_type'] = array(
			'type' 				=> 'string',
			'field'				=> 'post_mime_type',
			'function'		=> '',
			'default'			=> 0,
			'required'		=> false,
		);

		$type = $array_model['type']['field'];
		if ( !empty( $object->$type ) ) {
			$taxonomy_objects = get_object_taxonomies( $object->$type, 'objects' );
			foreach ( $taxonomy_objects as $taxonomy => $taxonomy_def ) {
				$this->model['taxonomy'][$taxonomy] = array(
					'type' => 'array',
					'function'	=> 'post_ctr_01::eo_get_object_terms',
					'field'	=> '',
					'default'	=> array(),
					'required'	=> false,
				);
			}
		}

		parent::__construct( $object, $meta_key, $cropped );
	}

}
