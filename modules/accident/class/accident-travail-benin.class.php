<?php
/**
 * Gères la génération de l'ODT: accident travail benin
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.3.0
 * @version 7.0.0
 * @copyright 2015-2018
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères la génération de l'ODT: accident travail benin
 */
class Accident_Travail_Benin_Class extends Document_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Accident_Travail_Benin_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'accident_benin';

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
	protected $base = 'accident-travail-benin';

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
	public $element_prefix = 'AT';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Accident travail benin';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @var string
	 */
	protected $odt_name = 'accident_benin';
}

Accident_Travail_Benin_Class::g();
