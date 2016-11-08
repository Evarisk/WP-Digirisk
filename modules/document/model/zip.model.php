<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class ZIP_Model extends post_model {
	/**
	 * [__construct description]
	 * @param [type] $object       [description]
	 * @param array  $field_wanted [description]
	 */
	public function __construct( $object, $field_wanted = array() ) {
		$this->model = array_merge( $this->model, array(
			'list_file_path' => array(
				'type' 		=> 'array',
				'meta_type'	=> 'multiple',
			),
			'duer_parent_id' => array(
				'type' 				=> 'integer',
				'meta_type'		=> 'single',
				'field'				=> 'duer_parent_id',
			),
		) );

		parent::__construct( $object, $field_wanted );
	}
}
