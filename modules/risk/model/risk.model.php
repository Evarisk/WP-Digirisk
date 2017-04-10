<?php
/**
 * Le modèle d'un risque
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Le modèle d'un risque
 */
class Risk_Model extends Post_Model {

	/**
	 * Constructeur
	 * @param [type] $object       [description]
	 * @param array  $field_wanted [description]
	 */
	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'associated_recommendation' => array(
				'type' 		=> 'array',
				'meta_type'	=> 'multiple',
			),
			'risk_date' => array(
				'type' 		=> 'array',
				'meta_type'	=> 'multiple',
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
			'current_evaluation_id' => array(
				'type'			=> 'integer',
				'meta_type' => 'multiple',
				'bydefault'	=> 0,
				'required'	=> true,
			),
			'associated_document_id' => array(
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
			),
			'taxonomy' => array(
				'type' => 'array',
				'meta_type' => 'multiple',
				'child' => array(
					'digi-danger' => array(
						'meta_type' => 'multiple',
						'array_type'	=> 'integer',
						'type' => 'array',
					),
					'digi-danger-category' => array(
						'meta_type' => 'multiple',
						'array_type'	=> 'integer',
						'type' => 'array',
					),
					'digi-method' => array(
						'meta_type' => 'multiple',
						'array_type'	=> 'integer',
						'type' => 'array',
					),
				),
			),
		) );

		$this->model['preset'] = array(
			'type' 				=> 'boolean',
			'meta_type'		=> 'single',
			'field'				=> '_wpdigi_preset',
			'bydefault' 	=> false,
		);

		parent::__construct( $object );
	}

}
