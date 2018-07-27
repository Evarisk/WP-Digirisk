<?php
/**
 * Définition des champs d'un tier.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition d'un tier
 */
class Third_Model extends \eoxia001\post_model {

	/**
	 * Définition des champs
	 *
	 * @param Object $object La définition des champs.
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 */
	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'full_name' => array(
				'type' => 'string',
				'meta_type' => 'multiple',
				'bydefault' => '',
			),
			'contact' => array(
				'meta_type' => 'multiple',
				'type' => 'array',
				'child' => array(
					'phone' => array(
						'type' => 'string',
						'bydefault' => '',
						'meta_type' => 'multiple',
					),
					'email' => array(
						'type' => 'string',
						'bydefault' => '',
						'meta_type' => 'multiple',
					),
					'address_id' => array(
						'type' => 'integer',
						'bydefault' => 0,
						'meta_type' => 'multiple',
					),
				),
			),
			'opening_time' => array(
				'type' => 'string',
				'bydefault' => '',
				'meta_type' => 'multiple',
			),
		) );
		parent::__construct( $object );
	}

}
