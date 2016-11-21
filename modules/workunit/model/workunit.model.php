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
class workunit_model extends society_model {

	public function __construct( $object, $field_wanted = array(), $args = array() ) {
		$this->model = array_merge( $this->model, array(
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
			'child' => array(
				'recommendation' => array(
					'export'			=> true,
					'type'				=> 'object',
					'controller' 	=> '\digi\recommendation_class',
					'field'				=> 'post_parent'
				),
			),
			'associated_recommendation' => array(
				'type' 		=> 'array',
				'meta_type'	=> 'multiple',
			),
		) );

		parent::__construct( $object, $field_wanted, $args );
	}

}
