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
class legal_display_model extends post_model {

	/**
	 * Définition du modèle d'un risque / Define a risk model
	 *
	 * @var array
	 */
	protected $array_option = array(
		'detective_work_id' => array(
      'type' => 'integer'
		),
		'occupational_health_service_id' => array(
    	'type' => 'integer'
		),
		'emergency_service' => array(
			'samu' => array(
				'type' => 'string'
			),
			'police' => array(
				'type' => 'string'
			),
			'pompier' => array(
				'type' => 'string'
			),
			'emergency' => array(
				'type' => 'string'
			),
			'right_defender' => array(
				'type' => 'string'
			),
			'poison_control_center' => array(
				'type' => 'string'
			)
		),
		'safety_rule' => array(
			'responsible_for_preventing' => array(
				'type' => 'string'
			),
			'phone' => array(
				'type' => 'string'
			),
			'location_of_detailed_instruction' => array(
				'type' => 'string'
			)
		),
		'working_hour' => array(
			'monday_morning' => array(
				'type' => 'string',
			),
			'tuesday_morning' => array(
				'type' => 'string',
			),
			'wednesday_morning' => array(
				'type' => 'string',
			),
			'thursday_morning' => array(
				'type' => 'string',
			),
			'friday_morning' => array(
				'type' => 'string',
			),
			'saturday_morning' => array(
				'type' => 'string',
			),
			'sunday_morning' => array(
				'type' => 'string',
			),
			'monday_afternoon' => array(
				'type' => 'string',
			),
			'tuesday_afternoon' => array(
				'type' => 'string',
			),
			'wednesday_afternoon' => array(
				'type' => 'string',
			),
			'thursday_afternoon' => array(
				'type' => 'string',
			),
			'friday_afternoon' => array(
				'type' => 'string',
			),
			'saturday_afternoon' => array(
				'type' => 'string',
			),
			'sunday_afternoon' => array(
				'type' => 'string',
			),
		),
		'derogation_schedule' => array(
			'permanent' => array(
				'type' => 'string',
			),
			'occasional' => array(
				'type' => 'string',
			),
		),
		'collective_agreement' => array(
			'title_of_the_applicable_collective_agreement' => array(
				'type' => 'string'
			),
			'location_and_access_terms_of_the_agreement' => array(
				'type' => 'string'
			)
		),
		'DUER' => array(
			'how_access_to_duer' => array(
				'type' => 'string'
			)
		),
		'rules' => array(
			'location' => array(
				'type' => 'string'
			)
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
		$type = $array_model['type']['field'];

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
