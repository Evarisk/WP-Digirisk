<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class danger_model extends term_model {

	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'status' => array(
				'export'			=> true,
				'type' 				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> '_wpdigi_status',
				'bydefault'			=> '',
			),
			'unique_key' => array(
				'type' 		=> 'string',
				'meta_type'		=> 'single',
				'field'		=> '_wpdigi_unique_key',
				'bydefault'	=> '',
			),
			'unique_identifier' => array(
				'type' 		=> 'string',
				'meta_type' => 'multiple',
				'bydefault'	=> '',
			),
			'thumbnail_id' => array(
				'type' 		=> 'integer',
				'meta_type'		=> 'single',
				'field'		=> '_thumbnail_id',
				'bydefault'	=> 0,
			),
			'default_method' => array(
				'type' 		=> 'integer',
				'meta_type' => 'multiple',
				'bydefault'	=> 0,
			),
			'default_of_category' => array(
				'type' 		=> 'boolean',
				'meta_type' => 'multiple',
				'bydefault'	=> false,
			),
			'is_annoying' => array(
				'type' 		=> 'boolean',
				'meta_type' => 'multiple',
				'bydefault'	=> false,
			),
		) );

		parent::__construct( $object );
	}

}
