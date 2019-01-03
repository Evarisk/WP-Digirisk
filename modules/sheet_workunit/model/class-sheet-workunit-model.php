<?php
/**
 * Définition du schéma d'une fiche d'unité de travail
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition du schéma d'une fiche d'unité de travail
 */
class Sheet_Workunit_Model extends Document_Model {

	/**
	 * Définition du schéma d'une fiche d'unité de travail
	 *
	 * @since 6.2.1
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['document_meta'] = array(
			'since'     => '6.2.1',
			'version'   => '6.5.0',
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
		);

		parent::__construct( $data, $req_method );
	}

}
