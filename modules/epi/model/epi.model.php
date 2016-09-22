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
				'meta_type'		=> 'single',
				'field'				=> '_serial_number',
				'required'		=> true,
			),
			'production_date' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
				'required'		=> true,
			),
			'lifetime' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
				'required'		=> true,
			),
			'review' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple'
			)
		) );

		$this->model['title']['required'] = true;
		$this->model['content']['required'] = true;

		parent::__construct( $object, $field_wanted );
	}

}
