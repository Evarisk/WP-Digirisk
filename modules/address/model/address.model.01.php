<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier de gestion des modèles pour les adresses dans Digirisk / Addresses management file for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe de gestion des modèles pour les adresses dans Digirisk / Addresses management class for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_address_mdl_01 extends comment_mdl_01 {

	/**
	 * Définition du modèle d'une adresse / Define a danger address
	 *
	 * @var array
	 */
	protected $array_option = array(
		'address' => array(
			'type' 		=> 'string',
			'function'	=> '',
			'default'	=> '',
			'required'	=> true,
		),
		'additional_address' => array(
			'type' 		=> 'string',
			'function'	=> '',
			'default'	=> '',
			'required'	=> true,
		),
		'postcode' => array(
			'type' 		=> 'string',
			'function'	=> '',
			'default'	=> '',
			'required'	=> true,
		),
		'town' => array(
			'type' 		=> 'string',
			'function'	=> '',
			'default'	=> '',
			'required'	=> true,
		),
		'state' => array(
			'type' 		=> 'string',
			'function'	=> '',
			'default'	=> '',
			'required'	=> true,
		),
		'country' => array(
			'type' 		=> 'string',
			'function'	=> '',
			'default'	=> '',
			'required'	=> true,
		),
		'coordinate' => array(
			'type' 		=> 'array',
			'function'	=> '',
			'default'	=> '',
			'required'	=> true,
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
