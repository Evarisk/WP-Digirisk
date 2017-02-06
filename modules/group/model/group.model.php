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
	public function __construct( $object ) {
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
				),
				'address_id' => array(
					'type'			=> 'array',
					'meta_type'	=> 'multiple',
				),
			),
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
			),
		);

		parent::__construct( $object );
	}

}
