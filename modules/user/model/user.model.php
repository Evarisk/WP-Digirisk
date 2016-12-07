<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier contenant le modèle pour les utilisateurs / File containing the main user model
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe définissant le modèle pour les utilisateurs / Class defining the main user model
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class user_digi_model extends user_model {

	/**
	* Construit le modèle d'un utilisateur / Fill the user model
	*
	* @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	* @param string $meta_key Le nom de la metakey utilisée pour le rangement des données associées à l'élément / The main metakey used to store data associated to current object
	* @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	*/
	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'hiring_date' => array(
				'type'				=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> 'Pas configuré'
			),
			'social_security_number' => array(
				'type'		=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> '',
			),
			'job' => array(
				'type'		=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> '',
			),
			"phone_number" => array(
				'type'			=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault' => ''
			),
			'release_date_of_society' => array(
				'type'		=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> '',
			),
			'professional_qualification' => array(
				'type'		=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> '',
			),
			'sexe' => array(
				'type'		=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> '',
			),
			'nationality' => array(
				'type'		=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> '',
			),
			'insurance_compagny' => array(
				'type'		=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> '',
			),
			'dashboard_compiled_data' => array(
				'type'			=> 'array',
				'meta_type'	=> 'multiple',
				'child'			=> array(
					'last_evaluation_date' => array(
						'type'	=> 'string',
						'meta_type' => 'multiple',
						'bydefault' => 'Pas d\'évaluation',
					),
					'list_workunit_id' => array(
						'type' => 'array',
						'meta_type'	=> 'multiple',
					),
					'list_evaluation_id' => array(
						'type'	=> 'array',
						'meta_type'	=> 'multiple',
					),
					'list_accident_id' => array(
						'type'	=> 'array',
						'meta_type'	=> 'multiple',
					),
					'list_stop_day_id' => array(
						'type'	=> 'array',
						'meta_type'	=> 'multiple',
					),
					'list_chemical_product_id' => array(
						'type'	=> 'array',
						'meta_type'	=> 'multiple',
					),
					'list_epi_id' => array(
						'type'	=> 'array',
						'meta_type'	=> 'multiple',
					)
				)
			)
		) );

		parent::__construct( $object );
	}


}

?>
