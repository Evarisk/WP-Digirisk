<?php
/**
 * Fait l'affichage du template de la liste des documents uniques
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.2.1
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
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
	protected $type = 'duer';

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
	 *
	 * @param  [type] $element_id [description]
	 * @return [type]             [description]
	 */
	public function display( $parent_id, $types, $can_add = true ) {
		$element = $this->get( array(
			'posts_per_page' => 1,
			'order'          => 'DESC',
			'post_parent'    => $parent_id,
			'post_status'    => array( 'publish', 'inherit' ),
		), true );

		if ( empty( $element ) ) {
			$element = $this->get( array(
				'schema' => true,
			), true );
		}

		$documents = $this->get( array(
			'post_parent' => $parent_id,
			'post_status' => array( 'publish', 'inherit' ),
		) );

		\eoxia\View_Util::exec( 'digirisk', 'duer', 'main', array(
			'element'    => $element,
			'element_id' => $parent_id,
			'documents'  => $documents,
		) );
	}

	/**
	 * Récupères les enfants pour l'affichage dans la popup pour générer le DUER.
	 *
	 * @since   6.2.3
	 *
	 * @param integer $parent_id L'ID de la société parent.
	 */
	public function display_childs( $parent_id = 0 ) {
		$societies = Society_Class::g()->get(
			array(
				'posts_per_page' => -1,
				'post_parent'    => $parent_id,
				'post_type'      => array( Group_Class::g()->get_type(), Workunit_Class::g()->get_type() ),
				'post_status'    => array( 'publish', 'inherit' ),
				'orderby'        => array(
					'menu_order' => 'ASC',
					'date'       => 'ASC',
				),
			)
		);

		\eoxia\View_Util::exec( 'digirisk', 'duer', 'tree/tree', array(
			'societies' => $societies,
		) );
	}

	public function generate_full_duer( $parent_id, $date_debut_audit, $date_fin_audit, $destinataire_duer, $methodologie, $sources, $dispo_des_plans, $remarque_importante ) {
		$society = Society_Class::g()->show_by_type( $parent_id );

		\eoxia\LOG_Util::log( 'DEBUT - Construction des données du DUER en BDD', 'digirisk' );
		$data = DUER_Class::g()->prepare_document( $society, array(
			'parent_id'           => 0,
			'date_debut_audit'    => $date_debut_audit,
			'date_fin_audit'      => $date_fin_audit,
			'destinataire_duer'   => $destinataire_duer,
			'methodologie'        => $methodologie,
			'sources'             => $sources,
			'dispo_des_plans'     => $dispo_des_plans,
			'remarque_importante' => $remarque_importante,
		) );
		\eoxia\LOG_Util::log( 'FIN - Construction des données du DUER en BDD', 'digirisk' );
		$generation_status = DUER_Class::g()->create_document( $data['document']->data['id'] );

		return $data;
	}
}

DUER_Class::g();
