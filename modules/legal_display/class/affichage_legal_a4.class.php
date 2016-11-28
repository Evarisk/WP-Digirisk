<?php
/**
 * Permet de définir l'objet Affichage_Legal_A3
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Permet de définir l'objet Affichage_Legal_A3
 */
class Affichage_Legal_A4_Class extends Post_Class {
	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name   				= '\digi\affichage_legal_a4_model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type    				= 'affichage_legal_A4';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	public $attached_taxonomy_type  = 'attachment_category';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key    					= '_wpdigi_document';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base 								= 'digirisk/affichage_legal_a4';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version 							= '0.1';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix 					= 'AL-A4-';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_put_function = array( '\digi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier' );

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Affichages légal A4';

	/**
	 * Le constructeur
	 *
	 * @return void
	 */
	protected function construct() {
		parent::construct();
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}
}

Affichage_Legal_A4_Class::g();
