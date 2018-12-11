<?php
/**
 * Classe gérant les documents ODT de DigiRisk.
 *
 * Cette classe génère les documents ODT.
 * Cette classe affiche les documents ODT.
 * Cette classe permet d'obtenir le lien de n'importe quel document ODT.
 * Cette classe permet de récupérer le chemin vers un modèle ODT (document unique, fiche de groupement, ..).
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Document class.
 */
class Document_Class extends \eoxia\ODT_Class {

	/**
	 * Le nom du modèle
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Document_Model';

	/**
	 * Le post type
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 * @todo:  Détruis la route de WordPress /wp-json/wp/v2/media (A changer très rapidement) (Toujours présent 25/06/2018)
	 */
	protected $type = 'attachment';

	/**
	 * La taxonomie
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 */
	public $attached_taxonomy_type = 'attachment_category';

	/**
	 * La clé principale du modèle
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_document';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 */
	public $element_prefix = 'DOC';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 */
	protected $base = 'document';

	/**
	 * Les documents acceptés
	 *
	 * @since 6.0.0
	 *
	 * @var array Un tableau de "string".
	 */
	public $mime_type_link = array(
		'application/vnd.oasis.opendocument.text' => '.odt',
		'application/zip'                         => '.zip',
	);

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 */
	protected $odt_name = '';

	/**
	 * Tableau contenant les messages à afficher dans la vue de la génération
	 * de ce document.
	 *
	 * @since 7.0.0
	 */
	protected $messages = array();

	protected function construct() {
		$this->path = PLUGIN_DIGIRISK_PATH;
		$this->url  = PLUGIN_DIGIRISK_URL;
		parent::construct();
	}

	/**
	 * Affiches le tableau contenant la liste des documents selon $parent_id et
	 * $types.
	 *
	 * @since 6.0.0
	 *
	 * @param  integer $parent_id L'élément parent ou les documents sont
	 * attachés.
	 * @param  array   $types     Les types des documents.
	 * @param  boolean $can_add   True pour faire apparaître le template
	 * d'ajout d'un document.
	 */
	public function display( $parent_id, $types, $can_add = true ) {
		$element = Society_Class::g()->show_by_type( $parent_id );

		$documents = array();

		if ( ! empty( $types ) ) {
			foreach ( $types as $type ) {
				$documents = wp_parse_args( $documents, $type::g()->get( array(
					'post_parent' => $parent_id,
					'post_status' => array( 'publish', 'inherit' ),
				) ) );
			}
		}

		\eoxia\View_Util::exec( 'digirisk', 'document', 'main', array(
			'_this'     => $this,
			'element'   => $element,
			'documents' => $documents,
			'can_add'   => $can_add,
		) );
	}

	public function prepare_document( $parent, $args = array() ) {
		$args = wp_parse_args( $args, array(
			'parent' => $parent,
		) );

		$document_data = apply_filters( 'digi_' . $this->get_type() . '_document_data', array(), $args );

		return $this->save_document_data( $parent->data['id'], $document_data, $args );
	}
}

Document_Class::g();
