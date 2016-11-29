<?php if ( !defined( 'ABSPATH' ) ) exit;

class chemi_product_model extends post_model {

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
			'associated_document_id' => array(
				'type'					=> 'array',
				'meta_type'			=> 'multiple',
				'child' 				=> array(
					'image' 			=> array(
						'type'			=> 'array',
						'meta_type'	=> 'multiple'
					)
				)
			),
			'CAS_number' => array(
				'type'				=> 'integer',
				'meta_type'		=> 'multiple',
				'required'		=> true,
			),
			'reference' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
				'required'		=> true,
			),
		) );

		$this->model['title']['required'] = true;
		$this->model['content']['required'] = true;

		parent::__construct( $object );
	}

}
