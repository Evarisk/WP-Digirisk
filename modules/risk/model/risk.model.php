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
class risk_model extends post_model {

	/**
	 * Constructeur
	 * @param [type] $object       [description]
	 * @param array  $field_wanted [description]
	 */
	public function __construct( $object, $field_wanted = array(), $args = array() ) {
		$this->model = array_merge( $this->model, array(
			'child' => array(
				'evaluation' => array(
					'export'			=> true,
					'type' 				=> 'object',
					'controller'	=> '\digi\risk_evaluation_class',
					'field'					=> 'comment__in',
					'value'					=> 'current_evaluation_id',
				),
				'danger_category' => array(
					'export'			=> true,
					'type'				=> 'taxonomy',
					'controller'	=> '\digi\category_danger_class',
					'field'				=> 'post_id',
				),
				'comment' => array(
					'export'			=> true,
					'type'				=> 'object',
					'controller'	=> '\digi\risk_evaluation_comment_class',
					'field'				=> 'post_id',
				),
				'evaluation_method' => array(
					'export'			=> true,
					'type'				=> 'object',
					'controller' 	=> '\digi\evaluation_method_class',
					'field'				=> 'post_id',
				),
				'recommendation' => array(
					'export'			=> true,
					'type'				=> 'object',
					'controller' 	=> '\digi\recommendation_class',
					'field'				=> 'post_parent',
				),
			),
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
						'type' => 'array'
					),
					'digi-danger-category' => array(
						'meta_type' => 'multiple',
						'array_type'	=> 'integer',
						'type' => 'array'
					),
					'digi-method' => array(
						'meta_type' => 'multiple',
						'array_type'	=> 'integer',
						'type' => 'array'
					)
				)
			)
		) );
		parent::__construct( $object, $field_wanted, $args );
	}

}
