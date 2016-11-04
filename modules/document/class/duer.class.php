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
class DUER_Class extends attachment_class {
	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name   				= '\digi\DUER_Model';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	protected $post_type    				= 'attachment';

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
	protected $base 								= 'digirisk/document-unique';

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
	public $element_prefix 					= 'DU';

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
	 * Ajout du filtre pour la Rest API
	 *
	 * @return void
	 */
	protected function construct() {
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	 * Appelle le template main.view.php dans le dossier /view/document-unique
	 *
	 * @param  int $element_id L'ID de l'élement.
	 * @return void
	 */
	public function display( $element_id ) {
		view_util::exec( 'document', 'DUER/main', array( 'element_id' => $element_id ) );
	}

	/**
	 * Appelle le template list.view.php dans le dossier /view/document-unique
	 *
	 * @param  int $element_id L'ID de l'élement.
	 * @return void
	 */
	public function display_document_list( $element_id ) {
		view_util::exec( 'document', 'DUER/list' );
	}
}

DUER_Class::g();
