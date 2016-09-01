<?php if ( !defined( 'ABSPATH' ) ) exit;

class risk_model extends post_model {

	public function __construct( $object, $field_wanted = array() ) {
		$this->model = array_merge( $this->model, array(
			'child' => array(
				'evaluation' => array(
					'export'			=> true,
					'type' 				=> 'object',
					'controller'	=> 'risk_evaluation_class',
					'field'					=> 'id',
					'value'					=> 'current_evaluation_id',
					'custom_field'	=> 'id',
				),
				'danger_category' => array(
					'export'			=> true,
					'type'				=> 'taxonomy',
					'controller'	=> 'danger_category_class',
					'field'				=> 'post_id',
				),
				'comment' => array(
					'export'			=> true,
					'type'				=> 'object',
					'controller'	=> 'risk_evaluation_comment_class',
					'field'				=> 'post_id'
				),
				'evaluation_method' => array(
					'export'			=> true,
					'type'				=> 'object',
					'controller' 	=> 'evaluation_method_class',
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
			'current_evaluation_id' => array(
				'type'			=> 'integer',
				'meta_type' => 'multiple',
				'bydefault'	=> 0,
			),
			'taxonomy' => array(
				'type' => 'array',
				'child' => array(
					'digi-danger' => array(
						'type' => 'array'
					),
					'digi-danger-category' => array(
						'type' => 'array'
					),
					'digi-method' => array(
						'type' => 'array'
					)
				)
			)
		) );
		parent::__construct( $object, $field_wanted );
	}

}
