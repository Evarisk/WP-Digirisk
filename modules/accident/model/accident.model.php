<?php if ( !defined( 'ABSPATH' ) ) exit;

class accident_model extends post_model {

	public function __construct( $object, $field_wanted = array(), $args = array() ) {
		$this->model = array_merge( $this->model, array(
			'child' => array(
				'list_risk' => array(
					'type'				=> 'array',
					'controller' 	=> 'risk_class',
					'field'				=> 'id',
					'value'				=> 'risk_id'
				),
				'list_user' => array(
					'type'				=> 'array',
					'controller' 	=> '\digi\user_class',
					'field'				=> 'id',
					'value'				=> 'user_id'
				),
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
			'risk_id' => array(
				'type'				=> 'integer',
				'meta_type'	=> 'multiple',
				'required'	=> true,
			),
			'accident_date' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
				'required'		=> true,
			),
			'user_id' => array(
				'type'				=> 'integer',
				'meta_type'		=> 'multiple',
				'required'		=> true,
			),
			'number_stop_day' => array(
				'type'				=> 'integer',
				'meta_type'		=> 'multiple',
				'required'		=> true,
			)
		) );

		$this->model['content']['required'] = true;

		parent::__construct( $object, $field_wanted, $args );
	}

}
