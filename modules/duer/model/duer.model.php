<?php
/**
 * Définition des champs d'un document DUER.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un document DUER.
 */
class DUER_Model extends Document_Model {

	/**
	 * Définition des champs
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['zip_path'] = array(
			'since'     => '6.2.1',
			'version'   => '6.2.1',
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => 'zip_path',
		);

		$this->schema['document_meta'] = array(
			'since'     => '6.2.1',
			'version'   => '6.2.1',
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
			'child'     => array(),
		);

		parent::__construct( $data, $req_method );
	}

}
