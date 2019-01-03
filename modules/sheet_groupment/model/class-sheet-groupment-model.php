<?php
/**
 * Définition du schéma d'une fiche de groupement.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.6
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition du schéma d'une fiche de groupement.
 */
class Sheet_Groupment_Model extends Document_Model {

	/**
	 * Définition du schéma d'une fiche de groupement.
	 *
	 * @since 6.1.6
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['document_meta'] = array(
			'since'     => '6.1.6',
			'version'   => '6.5.0',
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
		);

		parent::__construct( $data, $req_method );
	}

}
