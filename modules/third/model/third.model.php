<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class third_model extends post_model {

	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'full_name' => array(
				'type' 			=> 'string',
				'meta_type' => 'multiple',
				'bydefault' => ''
			),
			'contact' => array(
				'meta_type' => 'multiple',
				'type'			=> 'array',
				'child' => array(
					'phone' => array(
						'type'	=> 'string',
						'bydefault' => '',
						'meta_type' => 'multiple',
					),
					'address_id' => array(
						'type'	=> 'integer',
						'bydefault'	=> 0,
						'meta_type' => 'multiple',
					)
				)
			),
			'opening_time' => array(
				'type' => 'string',
				'bydefault' => '',
				'meta_type' => 'multiple',
			)
		) );
		parent::__construct( $object );
	}

}
