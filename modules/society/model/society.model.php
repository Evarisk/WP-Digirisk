<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class Society_Model extends \eoxia\Post_Model {

	public function __construct( $object ) {
		$this->model['associated_document_id'] = array(
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
		);

		$this->model['unique_key'] = array(
			'type' 				=> 'string',
			'meta_type'		=> 'single',
			'field'				=> '_wpdigi_unique_key',
		);

		$this->model['unique_identifier'] = array(
			'type' 				=> 'string',
			'meta_type'		=> 'single',
			'field'				=> '_wpdigi_unique_identifier',
		);

		$this->model['associated_recommendation'] = array(
			'type' 		=> 'array',
			'meta_type'	=> 'multiple',
		);

		parent::__construct( $object );
	}

}
