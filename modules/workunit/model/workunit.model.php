<?php if ( !defined( 'ABSPATH' ) ) exit;
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
class workunit_model extends post_model {

	public function __construct( $object, $field_wanted = array() ) {
		$this->model = array_merge( $this->model, array(
			'child' => array(
				'list_risk' => array(
					'export'			=> true,
					'type'				=> 'array',
					'controller' 	=> 'risk_class',
					'field'				=> 'post_parent',
				),
			),
			'user_info' => array(
				'type' => 'array',
				'meta_type'	=> 'multiple',
				'child' => array(
					'owner_id' => array(
						'type' 		=> 'integer',
						'meta_type'	=> 'multiple',
					),
					'affected_id' => array(
						'type' 		=> 'array',
						'meta_type'	=> 'multiple',
					),
				),
			),
			'contact' => array(
				'type' => 'array',
				'meta_type'	=> 'multiple',
				'child' => array(
					'phone' => array(
						'type'		=> 'array',
						'meta_type'	=> 'multiple',
						'bydefault' => array()
					),
					'address' => array(
						'type'		=> 'array',
						'meta_type'	=> 'multiple',
					),
				),
			),
			'identity' => array(
				'type' => 'array',
				'meta_type'	=> 'multiple',
				'child' => array(
					'workforce' => array(
						'type'		=> 'integer',
					),
				),
			),
			'associated_product' => array(
					'type'		=> 'array',
					'meta_type'	=> 'multiple',
			),
			'associated_recommendation' => array(
				'type' 		=> 'array',
				'meta_type'	=> 'multiple',
			),
			'associated_picture_id' => array(
				'type' 			=> 'array',
				'meta_type'	=> 'multiple',
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
			'unique_key' => array(
				'type' 				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> '_wpdigi_unique_key',
			),
			'unique_identifier' => array(
				'type' 				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> '_wpdigi_unique_identifier',
			)
		) );

		parent::__construct( $object, $field_wanted );
	}

}
