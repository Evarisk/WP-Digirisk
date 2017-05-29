<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class accident_model extends Post_Model {

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
			),
		) );

		$this->model['content']['required'] = true;

		parent::__construct( $object );
	}

}
