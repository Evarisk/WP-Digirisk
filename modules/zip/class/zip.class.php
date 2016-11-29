<?php
/**
 * Fait l'affichage du template de la liste des documents uniques
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.1.9.0
 * @copyright 2015-2016 Evarisk
 * @package document
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fait l'affichage du template de la liste des documents uniques
 */
class ZIP_Class extends Post_Class {
	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name   				= '\digi\ZIP_Model';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	protected $post_type    				= 'zip';

	/**
	 * A faire
	 *
	 * @todo
	 * @var string
	 */
	public $attached_taxonomy_type  = 'attachment_category';

	/**
	 * La clé principale de l'objet
	 *
	 * @var string
	 */
	protected $meta_key    					= '_wpdigi_document';

	/**
	 * La base de l'URI pour la Rest API
	 *
	 * @var string
	 */
	protected $base 								= 'digirisk/zip';

	/**
	 * La version pour la Rest API
	 *
	 * @var string
	 */
	protected $version 							= '0.1';

	/**
	 * Le préfixe pour le champs "unique_key" de l'objet
	 *
	 * @var string
	 */
	public $element_prefix 					= 'ZIP';

	/**
	 * Fonctions appelées avant le PUT
	 *
	 * @var array
	 */
	protected $before_put_function = array( '\digi\construct_identifier' );

	/**
	 * Fonctions appelées après le GET
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier' );

	/**
	 * La limite des documents affichés par page
	 * @var integer
	 */
	protected $limit_document_per_page = 50;

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'ZIP';

	/**
	 * Ajout du filtre pour la Rest API
	 *
	 * @return void
	 */
	protected function construct() {
		parent::construct();
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	 * Convertis le chemin absolu vers le fichier en URL
	 *
	 * @param  string $zip_path Le chemin absolu vers le fichier.
	 *
	 * @return string           L'URL vers le fichier
	 */
	public function get_zip_url( $zip_path ) {
		$url = document_class::g()->get_digirisk_dir_path( 'baseurl' );
		$zip_path_exploded = explode( 'digirisk/', $zip_path );
		$url .= '/' . $zip_path_exploded[1];
		return $url;
	}
}

ZIP_Class::g();
