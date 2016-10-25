<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class evaluation_method_variable_model extends term_model {

	public function __construct( $object, $field_wanted = array() ) {
		$this->model = array_merge( $this->model, array(
			'unique_key' => array(
				'type' 			=> 'string',
				'meta_type'	=> 'single',
				'field'			=> '_wpdigi_unique_key',
				'bydefault'	=> 0,
			),
			'unique_identifier' => array(
				'type' 			=> 'string',
				'meta_type'	=> 'multiple',
				'bydefault'	=> 0,
			),
			'display_type' => array(
				'type' 		=> 'string',
				'meta_type'	=> 'multiple',
			),
			'range' => array(
				'type' 		=> 'array',
				'meta_type'	=> 'multiple',
			),
			'survey' => array(
				'type' 		=> 'array',
				'meta_type'	=> 'multiple',
				// 'child'			=> array(
				// 	'title'	=> array(
				// 		'type'	=> 'string',
				// 		'bydefault'	=> null,
				// 	),
				// 	'request'	=> array(
				// 		'type'	=> 'array',
				// 		'bydefault'	=> null,
				// 	),
				// ),
			),
		) );

		parent::__construct( $object, $field_wanted );
	}

}
