<?php
/**
 * Définition des champs d'une adresse.
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
 * Définition d'une adresse
 */
class Address_Model extends \eoxia001\Comment_model {

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
			'address' => array(
				'type' => 'string',
				'meta_type' => 'multiple',
				'bydefault' => '',
			),
			'additional_address' => array(
				'type' => 'string',
				'meta_type' => 'multiple',
				'bydefault' => '',
			),
			'postcode' => array(
				'type' => 'string',
				'meta_type' => 'multiple',
				'bydefault' => '',
			),
			'town' => array(
				'type' => 'string',
				'meta_type' => 'multiple',
				'bydefault' => '',
			),
			'state' => array(
				'type' => 'string',
				'meta_type' => 'multiple',
				'bydefault' => '',
			),
			'country' => array(
				'type' => 'string',
				'meta_type' => 'multiple',
				'bydefault' => '',
			),
			'coordinate' => array(
				'type' => 'array',
				'meta_type' => 'multiple',
				'bydefault' => array(),
				'child' => array(
					'longitude' => array(
						'type' => 'string',
					),
					'latitude' => array(
						'type' => 'string',
					),
				),
			),
		) );

		parent::__construct( $object );
	}

}
