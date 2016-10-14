<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class recommendation_model extends post_model {

	public function __construct( $object, $field_wanted = array() ) {
		$this->model['child']['recommendation_category_term'] = array(
			'export'			=> true,
			'type'				=> 'taxonomy',
			'controller'	=> '\digi\recommendation_category_term_class',
			'field'				=> 'post_id',
		);

		$this->model['child']['comment'] = array(
			'export'			=> true,
			'type'				=> 'object',
			'controller'	=> '\digi\comment_class',
			'field'				=> 'post_id'
		);
		
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
						'type' => 'array'
					),
					'digi-recommendation-category' => array(
						'meta_type' => 'multiple',
						'type' => 'array'
					)
				)
			)
		) );
		parent::__construct( $object, $field_wanted );
	}

}
