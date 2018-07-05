<?php
/**
 * Classe héritant de Document_Class. Permet de définir les attributs "protected".
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.6
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe héritant de Document_Class. Permet de définir les attributs "protected".
 */
class Legal_Display_A4_Class extends Document_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Legal_Display_A4_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'affichage_legal_A4';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	public $attached_taxonomy_type = 'attachment_category';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_document';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'affichage_legal_a4';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'AL-A4-';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Affichages légal A4';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @var string
	 */
	protected $odt_name = 'affichage_legal_A4';
}

Legal_Display_A4_Class::g();
