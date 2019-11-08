<?php
/**
 * Le modèle définissant les données d'une fiche d'un plan de prévention
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2019 Prevention.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Le modèle définissant les données d'une fiche de causerie.
 */
class Sheet_Prevention_Model extends Document_Model {

	/**
	 * Construit le modèle
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @param  Sheet_Prevention_Modal $object La définition de l'objet dans l'instance actuelle.
	 *
	 * @return Sheet_Prevention_Modal
	 */
	public function __construct( $object, $req_method ) {
		$this->schema['document_meta'] = array(
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
		);

		parent::__construct( $object, $req_method );
	}

}
