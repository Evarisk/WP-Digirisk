<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class risk_evaluation_model extends comment_model {

	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'risk_level' => array(
				'export' => true,
				'type' => 'array',
				'meta_type'	=> 'multiple',
				'child' => array(
					'method_result' => array(
						'type' 			=> 'integer',
						'meta_type'	=> 'multiple',
						'bydefault'	=> 0,
						'required'	=> true,
					),
					'equivalence' => array(
						'type' 			=> 'integer',
						'meta_type'	=> 'multiple',
						'bydefault'	=> 0,
						'required'	=> true,
					),
				),
			),
			'quotation_detail' => array(
				'export' => true,
				'type' => 'array',
				'meta_type'	=> 'multiple',
			),
			'equivalence' => array(
				'type' 		=> 'integer',
				'field'		=> '_wpdigi_risk_evaluation_equivalence',
				'meta_type'	=> 'single',
				'bydefault'			=> 0,
			),
			'scale' => array(
				'export' => true,
				'type' 		=> 'integer',
				'field'		=> '_wpdigi_risk_evaluation_scale',
				'meta_type'	=> 'single',
				'bydefault'			=> -1,
				'required'	=> true,
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
		) );

		parent::__construct( $object );
	}

}
