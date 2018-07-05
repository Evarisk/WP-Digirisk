<?php
/**
 * Définition du schéma des documents
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.0.0
 * @copyright 2015-2018 Evarisk
 * @package EOFramework
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition du schéma des documents
 */
class Document_Model extends \eoxia\ODT_Model {

	/**
	 * Définition du schéma des documents
	 *
	 * @since 6.0.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['mime_type'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => 'post_mime_type',
		);

		$this->schema['unique_key'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_key',
		);

		$this->schema['unique_identifier'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_identifier',
			'default'   => '',
		);

		parent::__construct( $data, $req_method );
	}

}
