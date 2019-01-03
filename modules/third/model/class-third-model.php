<?php
/**
 * Définition des champs d'un tier.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.3
 * @version 6.5.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un tier.
 */
class Third_Model extends \eoxia\Post_Model {

	/**
	 * Définition des champs d'un tier.
	 *
	 * @since 6.1.3
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['full_name'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['contact'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['contact']['child']['phone'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'default'   => '',
			'meta_type' => 'multiple',
		);

		$this->schema['contact']['child']['email'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'default'   => '',
			'meta_type' => 'multiple',
		);

		$this->schema['contact']['child']['address_id'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'integer',
			'default'   => 0,
			'meta_type' => 'multiple',
		);

		$this->schema['opening_time'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'default'   => '',
			'meta_type' => 'multiple',
		);

		parent::__construct( $data, $req_method );
	}

}
