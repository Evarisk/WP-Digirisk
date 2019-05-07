<?php
/**
 * Gères la génération de l'ODT: Registre Accidents de travail benins
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.3.0
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères la génération de l'ODT: Registre Accidents de travail benins
 */
class Registre_AT_Benin_Class extends Document_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Registre_AT_Benin_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'registre_at_benin';

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
	protected $base = 'registre-accidents-travail-benins';

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
	public $element_prefix = 'RATB';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Registre Accidents de Travail Benins';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @var string
	 */
	protected $odt_name = 'registre_accidents_travail_benins';

	/**
	 * Tableau contenant les messages à afficher dans la vue de la génération de ce document.
	 *
	 * @since 7.0.0
	 */
	protected $messages = array();

	/**
	 * Initialises les messages d'information pour la génération de l'ODT.
	 */
	protected function construct() {
		$this->message['empty']    = __( 'No generated register', 'digirisk' );
		$this->message['generate'] = __( 'Click to generate a minor accidents register', 'digirisk' );

		parent::construct();
	}
}

Accident_Travail_Benin_Class::g();
