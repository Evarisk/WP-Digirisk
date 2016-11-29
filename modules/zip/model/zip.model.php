<?php
/**
 * Le modèle du ZIP
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Le modèle du ZIP
 */
class ZIP_Model extends Post_Model {

	/**
	 * Le constructeur
	 *
	 * @param [type] $object       [description].
	 * @param array  $field_wanted [description].
	 * @param array  $args          [description].
	 */
	public function __construct( $object ) {
		$this->model['list_generation_results'] = array(
			'type' 		=> 'array',
			'meta_type'	=> 'multiple',
		);

		parent::__construct( $object );
	}

}
