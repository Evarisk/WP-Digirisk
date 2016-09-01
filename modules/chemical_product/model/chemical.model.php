<?php if ( !defined( 'ABSPATH' ) ) exit;

class chemical_model extends post_model {

 /**
	* Définition du modèle d'un produit chimique / Define a chemical model
	*
	* @var array
	*/
 protected $array_option = array(
	 'id' => array(
		 'type' => 'integer',
	 ),
	 'unique_identifier' => array(
		 'type' => 'string',
	 ),
	 'unique_key' => array(
		 'type' => 'string',
	 ),
	 'name' => array(
		 'type' => 'string',
	 ),
	 'description' => array(
		 'type' => 'string',
	 ),
	 'CAS_number' => array(
		 'type' => 'integer',
	 ),
	 'reference' => array(
		 'type' => 'string',
	 ),
	 'fds' => array(
		 'type' => 'boolean',
	 ),
	 'fds_media' => array(
		 'type' => 'media',
	 ),
	 'picture' => array(
		 'type' => 'string',
	 )
 );

 /**
	* Construit le modèle / Fill the model
	*
	* @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	* @param string $meta_key Le nom de la metakey utilisée pour le rangement des données associées à l'élément / The main metakey used to store data associated to current object
	* @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	*/
 public function __construct( $object, $field_wanted = array() ) {
	 $array_model = $this->get_model();
	 $type = $array_model['type']['field'];

	 if ( !empty( $object->$type ) ) {

		 $taxonomy_objects = get_object_taxonomies( $object->$type, 'objects' );
		 foreach ( $taxonomy_objects as $taxonomy => $taxonomy_def ) {
			 $this->model['taxonomy'][$taxonomy] = array(
				 'type' => 'array',
				 'function'	=> 'post_class::eo_get_object_terms',
				 'field'	=> '',
				 'default'	=> array(),
				 'required'	=> false,
			 );
		 }
	 }

	 parent::__construct( $object, $field_wanted );
 }

}
