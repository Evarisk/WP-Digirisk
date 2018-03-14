<?php
/**
 * Définition du schéma des adresses.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *  Définition du schéma des adresses.
 */
class Address_Model extends \eoxia\Comment_Model {

	/**
	 * Définition du schéma des adresses.
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['address'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['additional_address'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['postcode'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['town'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['state'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['country'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['coordinate'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['coordinate']['child']['longitude'] = array(
			'type' => 'string',
		);

		$this->schema['coordinate']['child']['latitude'] = array(
			'type' => 'string',
		);

		parent::__construct( $data, $req_method );
	}

}
