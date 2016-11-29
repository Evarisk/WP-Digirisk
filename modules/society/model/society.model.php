<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal de l'extension digirisk pour wordpress / Main controller file for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal de l'extension digirisk pour wordpress / Main controller class for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class society_model extends post_model {

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

		parent::__construct( $object );
	}

}
