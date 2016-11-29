<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class epi_model extends post_model {

	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'unique_key' => array(
				'type' 				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> '_wpdigi_unique_key',
			),
			'unique_identifier' => array(
				'type' 				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> '_wpdigi_unique_identifier',
			),
			'associated_document_id' => array(
				'type'				=> 'array',
				'meta_type'	=> 'multiple',
				'child' => array(
					'image' => array(
						'type'				=> 'array',
						'meta_type'	=> 'multiple'
					)
				)
			),
			'serial_number' => array(
				'type'				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> '_serial_number',
				'required'		=> true
			),
			'production_date' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
			),
			'frequency_control' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
				'required'		=> true
			),
			'control_date' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
				'required'		=> true
			),
			'compiled_remaining_time' => array(
				'type'				=> 'string',
				'meta_type'		=> 'field',
				'field'				=> '_compiled_remaining_time',
				'bydefault'		=> ''
			)
		) );

		$this->model['title']['required'] = true;

		parent::__construct( $object );
	}

}
