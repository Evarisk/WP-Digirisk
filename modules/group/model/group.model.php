<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class group_model extends society_model {
	/**
	 * Construit le modèle de groupement / Fill the group model
	 *
	 * @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	 * @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	 */
	public function __construct( $object, $field_wanted = array(), $args = array() ) {
		$this->model['child']['list_group'] = array(
			'export' 			=> true,
			'type'				=> 'array',
			'controller'	=> '\digi\group_class',
			'field'				=> 'post_parent',
		);

		$this->model['child']['list_workunit'] = array(
			'export'			=> true,
			'type'				=> 'array',
			'controller' 	=> '\digi\workunit_class',
			'field'				=> 'post_parent',
		);

		$this->model['child']['address'] = array(
			'type'				=> 'object',
			'controller'	=> '\digi\address_class',
			'field'				=> 'post_id'
		);

		$this->model['child']['owner_data'] = array(
			'type'				=> 'object',
			'controller'	=> '\digi\user_class',
			'field'				=> 'id',
		);

		$this->model['child']['thumbnail'] = array(
			'export' 			=> true,
			'type'				=> 'array',
			'controller'	=> '\digi\attachment_class',
			'field'				=> 'include',
			'value'				=> 'thumbnail_id'
		);

		$this->model['child']['attachment'] = array(
			'type'				=> 'array',
			'controller'	=> '\digi\attachment_class',
			'field'				=> 'include',
			'value'				=> 'associated_document_id[image]',
			'custom'			=> 'array'
		);

		$this->model['child']['associated_recommendation'] = array(
			'type' 		=> 'array',
			'meta_type'	=> 'multiple',
		);
		$this->model['child']['recommendation'] = array(
			'export'			=> true,
			'type'				=> 'object',
			'controller' 	=> '\digi\recommendation_class',
			'field'				=> 'post_id'
		);

		$this->model['user_info'] = array(
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
		);

		$this->model['contact'] = array(
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
		);

		$this->model['identity'] = array(
			'type'				=> 'array',
			'meta_type'	=> 'multiple',
			'child' => array(
				'workforce' => array(
					'type'			=> 'integer',
					'meta_type'	=> 'multiple',
				),
				'siren' => array(
					'type'			=> 'string',
					'meta_type'	=> 'multiple',
				),
				'siret' => array(
					'type'			=> 'string',
					'meta_type'	=> 'multiple',
				),
				'social_activity_number' => array(
					'type'			=> 'integer',
					'meta_type'	=> 'multiple',
				),
				'establishment_date' => array(
					'type'			=> 'string',
					'meta_type'	=> 'multiple',
				),
			)
		);

		parent::__construct( $object, $field_wanted, $args );
	}

}
