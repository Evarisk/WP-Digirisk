<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class recommendation_category_term_model extends term_model {

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
			'thumbnail_id' => array(
				'type' 			=> 'integer',
				'meta_type'	=> 'multiple',
			),
			'associated_document_id' => array(
				'type' 		=> 'array',
				'meta_type'	=> 'multiple',
			),
			'recommendation_category_print_option' => array(
				'type' 		=> 'array',
				'meta_type'	=> 'multiple',
			),
			'recommendation_print_option' => array(
				'type' 		=> 'array',
				'meta_type'	=> 'multiple',
			),
		) );

		parent::__construct( $object );
	}

}
