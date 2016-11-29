<?php
/**
 * Définition d'une addresse
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition d'une addresse
 *
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.1.0.0
 */
class Address_model extends Comment_model {
	/**
	 * La définition d'une addresse
	 *
	 * @param Address_model $object       L'objet avec ses données.
	 * @param array         $field_wanted Les enfants voulu dans l'objet.
	 */
	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'address' => array(
				'type' 			=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> '',
			),
			'additional_address' => array(
				'type' 			=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> '',
			),
			'postcode' => array(
				'type' 			=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> '',
			),
			'town' => array(
				'type' 			=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> '',
			),
			'state' => array(
					'type' 		=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> '',
			),
			'country' => array(
				'type' 			=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> '',
			),
			'coordinate' => array(
				'type' 			=> 'array',
				'meta_type'	=> 'multiple',
				'bydefault'	=> array(),
				'child'			=> array(
					'longitude' => array(
						'type' 			=> 'string',
					),
					'latitude' => array(
						'type' 			=> 'string',
					),
				),
			),
		)	);

		parent::__construct( $object );
	}

}
