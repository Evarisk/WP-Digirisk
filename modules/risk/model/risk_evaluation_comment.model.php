<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur pour la gestion des différentes évaluations pour un risque / Main controller file for managing each evaluation for a risk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur pour la gestion des différentes évaluations pour un risque / Main controller class for managing each evaluation for a risk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_riskevaluationcomment_mdl_01 extends comment_model {

	/**
	 * Définition du modèle d'une évaluation de risque / Define a risk evaluation model
	 *
	 * @var array
	 */
	protected $array_option = array(
		'unique_key' => array(
			'type' 			=> 'string',
			'field_type'	=> 'meta',
			'field'			=> '_wpdigi_unique_key',
			'function'		=> '',
			'default'		=> 0,
			'required'		=> true,
		),
		'unique_identifier' => array(
			'type' 			=> 'string',
			'field_type'	=> 'meta',
			'field'			=> '_wpdigi_unique_identifier',
			'function'		=> '',
			'default'		=> 0,
			'required'		=> true,
		),
		'export' => array(
			'type' 		=> 'boolean',
			'function'	=> '',
			'default'	=> 0,
			'required'	=> false,
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
		parent::__construct( $object, $meta_key, $cropped );
	}

}
