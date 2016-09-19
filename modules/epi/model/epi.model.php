<?php if ( !defined( 'ABSPATH' ) ) exit;

class epi_model extends post_model {

	public function __construct( $object, $field_wanted = array() ) {
		$this->model = array_merge( $this->model, array(
			'unique_key' => array(
				'export'			=> true,
				'type' 				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> '_wpdigi_unique_key',
			),
			'unique_identifier' => array(
				'export'			=> true,
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
				'type'				=> 'array',
				'meta_type'		=> 'single'
			)
		) );

		parent::__construct( $object, $field_wanted );
	}

}
