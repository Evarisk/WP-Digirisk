<?php
/**
 * Définition des champs d'un tier.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
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
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['full_name'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['contact'] = array(
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['contact']['child']['phone'] = array(
			'type'      => 'string',
			'default'   => '',
			'meta_type' => 'multiple',
		);

		$this->schema['contact']['child']['email'] = array(
			'type'      => 'string',
			'default'   => '',
			'meta_type' => 'multiple',
		);

		$this->schema['contact']['child']['address_id'] = array(
			'type'      => 'integer',
			'default'   => 0,
			'meta_type' => 'multiple',
		);

		$this->schema['opening_time'] = array(
			'type'      => 'string',
			'default'   => '',
			'meta_type' => 'multiple',
		);

		parent::__construct( $data, $req_method );
	}

}
