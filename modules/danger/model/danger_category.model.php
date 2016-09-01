<?php if ( !defined( 'ABSPATH' ) ) exit;

class category_danger_model extends term_model {

	public function __construct( $object, $children_wanted = array() ) {
		$this->model = array_merge( $this->model, array(
			'child' => array(
				'danger'	=> array(
					'export'			=> true,
					'type'				=> 'taxonomy',
					'controller'	=> 'danger_class',
					'field'					=> 'parent',
					'value'					=> 'post_id',
					'custom_field'	=> 'post_id',
				),
			),
		) );

		parent::__construct( $object, $children_wanted );
	}

}
