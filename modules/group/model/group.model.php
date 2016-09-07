<?php if ( !defined( 'ABSPATH' ) ) exit;

class group_model extends post_model {
	/**
	 * Construit le modèle de groupement / Fill the group model
	 *
	 * @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	 * @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	 */
	public function __construct( $object, $field_wanted = array() ) {

		$this->model = array_merge( $this->model, array(
			'child' => array(
				'list_group' => array(
					'export' 			=> true,
					'type'				=> 'array',
					'controller'	=> 'group_class',
					'field'				=> 'post_parent',
				),
				'list_risk' => array(
					'export'			=> true,
					'type'				=> 'array',
					'controller' 	=> 'risk_class',
					'field'				=> 'post_parent',
				),
				'list_workunit' => array(
					'export'			=> true,
					'type'				=> 'array',
					'controller' 	=> 'workunit_class',
					'field'				=> 'post_parent',
				),
				'address' => array(
					'type'				=> 'object',
					'controller'	=> 'address_class',
					'field'				=> 'post_id'
				),
				'owner_data' => array(
					'type'				=> 'object',
					'controller'	=> '\digi\user_class',
					'field'				=> 'id',
				),
				'thumbnail' => array(
					'export' 			=> true,
					'type'				=> 'array',
					'controller'	=> 'attachment_class',
					'field'				=> 'include',
					'value'				=> 'thumbnail_id'
				),
				'attachment' => array(
					'type'				=> 'array',
					'controller'	=> 'attachment_class',
					'field'				=> 'include',
					'value'				=> 'associated_document_id[image]',
					'custom'			=> 'array'
				)
			),
			'user_info' => array(
				'type'				=> 'array',
				'meta_type'	=> 'multiple',
				'child' => array(
					'owner_id' => array(
						'type' 			=> 'integer',
						'meta_type'	=> 'multiple',
					),
					'affected_id' => array(
						'type' 			=> 'array',
						'meta_type'	=> 'multiple',
					),
				),
			),
			'contact' => array(
				'type'				=> 'array',
				'meta_type'	=> 'multiple',
				'child' => array(
					'phone' => array(
						'type'			=> 'array',
						'meta_type'	=> 'multiple',
						'bydefault'	=> array( '01 02 03 04 05' )
					),
					'address_id' => array(
						'type'			=> 'array',
						'meta_type'	=> 'multiple',
					)
				)
			),
			'identity' => array(
				'type'				=> 'array',
				'meta_type'	=> 'multiple',
				'child' => array(
					'workforce' => array(
						'type'			=> 'integer',
					),
					'siren' => array(
						'type'			=> 'string',
						'meta_type'	=> 'multiple'
					),
					'siret' => array(
						'type'			=> 'string',
						'meta_type'	=> 'multiple'
					),
					'social_activity_number' => array(
						'type'			=> 'integer',
					)
				)
			),
			'associated_product' => array(
					'type'			=> 'array',
			),
			'associated_recommendation' => array(
				'type' 			=> 'array',
			),
			'associated_picture_id' => array(
				'type' 			=> 'array',
			),
			'associated_document_id' => array(
				'type'				=> 'array',
				'meta_type'	=> 'multiple',
				'child' => array(
					'image' => array(
						'type'				=> 'array',
						'meta_type'		=> 'multiple',
						'bydefault'		=> array()
					),
					'document' => array(
						'type'				=> 'array',
						'meta_type' 	=> 'multiple',
						'bydefault'		=> array()
					)
				)
			),
			'unique_key' => array(
				'type' 		=> 'string',
				'meta_type'		=> 'single',
				'field'		=> '_wpdigi_unique_key',
			),
			'unique_identifier' => array(
				'type' 			=> 'string',
				'meta_type'	=> 'single',
				'field'			=> '_wpdigi_unique_identifier',
			)
		) );

		parent::__construct( $object, $field_wanted );
	}

}
