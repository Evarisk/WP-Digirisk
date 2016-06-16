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
class legal_display_mdl_01 extends post_mdl_01 {

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
		'emmergency_service' => array(
			'ermergency' => array(
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
		'working_hour_id' => array(
			'type' => 'integer'
		),
		'derogation_schedules' => array(
			'permanent' => array(
				'type' => 'string',
			),
			'occasional' => array(
				'type' => 'string',
			),
		),
		'document' => array(
			'title_of_the_applicable_collective_agreement' => array(
				'type' => 'string'
			),
			'location_and_access_terms_of_the_agreement' => array(
				'type' => 'string'
			),
			'the_rule_of_procedure_display_location' => array(
				'type' => 'string'
			),
			'how_access_to_duer' => array(
				'type' => 'string'
			),
		)
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
