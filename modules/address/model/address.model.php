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
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['additional_address'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['postcode'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['town'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['state'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['country'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['coordinate'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['coordinate']['child']['longitude'] = array(
			'since'   => '6.0.0',
			'version' => '6.0.0',
			'type'    => 'string',
		);

		$this->schema['coordinate']['child']['latitude'] = array(
			'since'   => '6.0.0',
			'version' => '6.0.0',
			'type'    => 'string',
		);

		parent::__construct( $data, $req_method );
	}

}
