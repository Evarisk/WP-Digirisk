<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class recommendation_model extends post_model {

	public function __construct( $object, $field_wanted = array() ) {
		$this->model = array_merge( $this->model, array(
			'child' => array(
				'recommendation_category' => array(
					'export'			=> true,
					'type'				=> 'taxonomy',
					'controller'	=> '\digi\recommendation_category_term_class',
					'field'				=> 'post_id',
				),
				'comment' => array(
					'export'			=> true,
					'type'				=> 'object',
					'controller'	=> '\digi\risk_evaluation_comment_class',
					'field'				=> 'post_id'
				)
			),
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
