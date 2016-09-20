<?php if ( !defined( 'ABSPATH' ) ) exit;

class epi_model extends post_model {

	public function __construct( $object, $field_wanted = array() ) {
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
					)
				)
			),
			'serial_number' => array(
				'type'				=> 'string',
				'meta_type'		=> 'single'
			),
			'production_date' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
			),
			'lifetime' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple'
			),
			'rewiew' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple'
			)
		) );

		parent::__construct( $object, $field_wanted );
	}

}
