<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class Workunit_Model extends Society_Model {

	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'user_info' => array(
				'type' => 'array',
				'meta_type'	=> 'multiple',
				'child' => array(
					'owner_id' => array(
						'type' 		=> 'integer',
						'meta_type'	=> 'multiple',
					),
					'affected_id' => array(
						'type' 		=> 'array',
						'meta_type'	=> 'multiple',
					),
				),
			),
			'contact' => array(
				'type' => 'array',
				'meta_type'	=> 'multiple',
				'child' => array(
					'phone' => array(
						'type'		=> 'array',
						'meta_type'	=> 'multiple',
					),
					'address_id' => array(
						'type'		=> 'array',
						'meta_type'	=> 'multiple',
					),
				),
			),
			'identity' => array(
				'type' => 'array',
				'meta_type'	=> 'multiple',
				'child' => array(
					'workforce' => array(
						'type'		=> 'integer',
					),
				),
			),
		) );

		parent::__construct( $object );
	}

}
