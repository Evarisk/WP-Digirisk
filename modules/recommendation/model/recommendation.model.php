<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class recommendation_model extends post_model {

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
			'recommendation_type' => array(
				'type' 				=> 'string',
				'meta_type'		=> 'multiple',
			),
			'efficiency' => array(
				'type' 				=> 'string',
				'meta_type'		=> 'multiple',
			),
			'associated_document_id' => array(
				'type'				=> 'array',
				'meta_type'	=> 'multiple',
				'child' => array(
					'image' => array(
						'type'				=> 'array',
						'meta_type'	=> 'multiple'
					),
					'document' => array(
						'type'				=> 'array',
						'meta_type' => 'multiple',
					)
				)
			),
			'taxonomy' => array(
				'type' => 'array',
				'meta_type' => 'multiple',
				'child' => array(
					'digi-recommendation' => array(
						'meta_type' => 'multiple',
						'type' => 'array',
						'array_type' => 'int',
					),
					'digi-recommendation-category' => array(
						'meta_type' => 'multiple',
						'type' => 'array',
						'array_type' => 'int',
					)
				)
			)
		) );
		parent::__construct( $object );
	}

}
