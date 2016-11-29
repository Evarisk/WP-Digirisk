<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class evaluation_method_model extends term_model {

	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'unique_key' => array(
				'type' 			=> 'string',
				'meta_type'	=> 'single',
				'field'			=> '_wpdigi_unique_key',
				'default'	=> 0,
			),
			'unique_identifier' => array(
				'type' 			=> 'string',
				'meta_type'	=> 'multiple',
				'default'	=> 0,
			),
			'thumbnail_id' => array(
				'type' 		=> 'integer',
				'meta_type'	=> 'multiple',
				'required'	=> false,
			),
			'associated_document_id' => array(
				'type' 		=> 'array',
				'meta_type'	=> 'multiple',
			),
			'is_default' => array(
				'type' 		=> 'boolean',
				'meta_type'	=> 'multiple',
			),
			'formula' => array(
				'type' 		=> 'array',
				'meta_type'	=> 'multiple',
			),
			'matrix' => array(
				'type' 		=> 'array',
				'meta_type'	=> 'multiple',
			),
		) );
		parent::__construct( $object );
	}

}
