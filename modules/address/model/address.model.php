<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class address_model extends comment_model {
	public function __construct( $object, $field_wanted = array() ) {
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
				)
			),
		)	);

		parent::__construct( $object, $field_wanted );
	}

}
