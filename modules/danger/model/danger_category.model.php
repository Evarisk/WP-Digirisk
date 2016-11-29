<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class category_danger_model extends term_model {

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
			'position'	=> array(
				'type'	=> 'integer',
				'meta_type'		=> 'single',
				'field'		=> '_position',
				'bydefault'	=> 1,
			),
		) );

		parent::__construct( $object );
	}

}
