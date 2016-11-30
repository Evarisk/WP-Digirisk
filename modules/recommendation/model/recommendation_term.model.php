<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class recommendation_term_model extends term_model {

	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'unique_key' => array(
				'type' 				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> '_wpdigi_unique_key',
			),
			'unique_identifier' => array(
				'type' 			=> 'string',
				'meta_type'	=> 'single',
				'field'			=> '_wpdigi_unique_identifier',
			),
			'type' => array(
				'type' 			=> 'string',
				'meta_type'	=> 'multiple',
			),
			'thumbnail_id'	=> array(
				'type'			=> 'integer',
				'meta_type'	=> 'single',
				'field'			=> '_thumbnail_id',
			),
		) );

		parent::__construct( $object );
	}

}
