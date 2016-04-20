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
class wpdigi_recommendation_mdl_01 extends term_mdl_01 {

	/**
	 * Définition du modèle d'une catégorie de danger / Define a danger category model
	 *
	 * @var array
	 */
	protected $specific_array_option = array(
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
		'type' => array(
			'type' 		=> 'string',
			'function'	=> '',
			'default'	=> 0,
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
		$this->array_option =  array_merge( $this->array_option, $this->specific_array_option );

		parent::__construct( $object, $meta_key, $cropped );
	}

}
