<?php
/**
 * Fait l'affichage du template de la liste des documents uniques
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fait l'affichage du template de la liste des documents uniques
 */
class DUER_Class extends Document_Class {
	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\DUER_Model';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	protected $post_type = 'duer';

	/**
	 * La taxonomy du post
	 *
	 * @todo
	 * @var string
	 */
	public $attached_taxonomy_type = 'attachment_category';

	/**
	 * La clé principale de l'objet
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_document';

	/**
	 * La base de l'URI pour la Rest API
	 *
	 * @var string
	 */
	protected $base = 'document-unique';

	/**
	 * La version pour la Rest API
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le préfixe pour le champs "unique_key" de l'objet
	 *
	 * @var string
	 */
	public $element_prefix = 'DU';

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
	 *
	 * @var integer
	 */
	protected $limit_document_per_page = 50;

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'DUER';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @var string
	 */
	protected $odt_name = 'document_unique';

	/**
	 * Récupères les données du dernier DUER généré et appelle le template main.view.php.
	 *
	 * @param  int $element_id L'ID de l'élement.
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 */
	public function display( $element_id ) {
		$element = $this->get( array(
			'posts_per_page' => 1,
			'order'          => 'DESC',
			'post_parent'    => $element_id,
			'post_status'    => array( 'publish', 'inherit' ),
		), true );

		if ( empty( $element ) ) {
			$element = $this->get( array(
				'schema' => true,
			), true );
		}

		\eoxia\View_Util::exec( 'digirisk', 'duer', 'main', array(
			'element'    => $element,
			'element_id' => $element_id,
		) );
	}

	/**
	 * Appelle le template list.view.php dans le dossier /view/document-unique
	 *
	 * @param  int $element_id L'ID de l'élement.
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.2.7
	 */
	public function display_document_list( $element_id ) {
		$list_document = $this->get( array(
			'post_parent' => $element_id,
			'post_status' => array( 'publish', 'inherit' ),
		) );

		\eoxia\View_Util::exec( 'digirisk', 'duer', 'list', array(
			'list_document' => $list_document,
		) );
	}

	/**
	 * Permet d'appeler l'affichage pour afficher un arbre de société pour voir la génération des ODT pour chaque société
	 *
	 * @param integer $parent_id L'ID de la société parent.
	 * @return void
	 *
	 * @since 6.2.3.0
	 * @version 6.2.3.0
	 */
	public function display_group_tree( $parent_id = 0 ) {
		$groupments = Group_Class::g()->get(
			array(
				'posts_per_page' 	=> -1,
				'post_parent'			=> $parent_id,
				'post_status' 		=> array( 'publish', 'draft' ),
				'orderby'					=> array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
			)
		);

		\eoxia\View_Util::exec( 'digirisk', 'duer', 'tree/tree', array( 'societies' => $groupments ) );
	}

	public function display_workunit_tree( $parent_id = 0 ) {
		$workunits = Workunit_Class::g()->get(
			array(
				'posts_per_page' 	=> -1,
				'post_parent'			=> $parent_id,
				'post_status' 		=> array( 'publish', 'draft' ),
				'orderby'					=> array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
			)
		);

		\eoxia\View_Util::exec( 'digirisk', 'duer', 'tree/tree', array( 'societies' => $workunits ) );
	}
}

DUER_Class::g();
