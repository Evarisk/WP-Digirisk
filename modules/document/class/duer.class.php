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
	 * La limite des documents affichés par page
	 * @var integer
	 */
	protected $limit_document_per_page = 50;

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
		$element = $this->get( array( 'schema' => true ), array() );
		$element = $element[0];
		view_util::exec( 'document', 'DUER/main', array( 'element' => $element, 'element_id' => $element_id ) );
	}

	/**
	 * Appelle le template list.view.php dans le dossier /view/document-unique
	 *
	 * @param  int $element_id L'ID de l'élement.
	 * @return void
	 */
	public function display_document_list( $element_id ) {
		$element = society_class::g()->show_by_type( $element_id );
		$list_document_id = !empty( $element->associated_document_id ) && !empty( $element->associated_document_id[ 'document' ] ) ? $element->associated_document_id[ 'document' ] : null;

		if ( !empty( $list_document_id ) ) {
			$list_document_id = array_reverse( $list_document_id );
		}

		if ( 0 < $this->limit_document_per_page ) {
			$current_page = !empty( $_REQUEST[ 'next_page' ] ) ? (int)$_REQUEST[ 'next_page' ] : 1;
			$number_page = ceil( count ( $list_document_id ) / $this->limit_document_per_page );
			if ( !empty( $list_document_id ) ) {
				$list_document_id = array_slice( $list_document_id, ($current_page - 1) * $this->limit_document_per_page, $this->limit_document_per_page );
			}
		}

		$list_document = array();
		if ( !empty( $list_document_id ) ) {
			$list_document = $this->get( array( 'post__in' => $list_document_id ), array( 'category' ) );
		}

		view_util::exec( 'document', 'DUER/list', array( 'list_document' => $list_document ) );
	}
}

DUER_Class::g();
