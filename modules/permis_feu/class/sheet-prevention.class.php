<?php
/**
 * La classe gérant les feuilles du plan de prevention
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Causerie.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant les feuilles de causeries "intervention"
 */
class Sheet_Permis_Feu_Class extends Document_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Sheet_Permis_Feu_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'sheet-permisfeu';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	public $attached_taxonomy_type = 'attachment_category';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'digi-sheet-permisfeu';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_document';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'FPF';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Fiche permis de feu';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @var string
	 */
	 protected $odt_name = 'permis_de_feu';

	/**
	 * Cette méthode génère la fiche du plan de prévention
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @param integer $prevention_id L'ID de la causerie.
	 */
}

Sheet_Prevention_Class::g();
