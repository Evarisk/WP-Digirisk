<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class Diffusion_Informations_Model extends \eoxia\Post_Model {

	public function __construct( $object ) {
		$this->model['document_meta'] = array(
			'type'				=> 'array',
			'meta_type' 	=> 'single',
			'field'				=> 'document_meta',
			'child' => array(
				'delegues_du_personnels_date' => array(
					'type' => 'string',
				),
				'delegues_du_personnels_titulaires' => array(
					'type' => 'string',
				),
				'delegues_du_personnels_suppleants' => array(
					'type' => 'string',
				),
				'membres_du_comite_entreprise_date' => array(
					'type' => 'string',
				),
				'membres_du_comite_entreprise_titulaires' => array(
					'type' => 'string',
				),
				'membres_du_comite_entreprise_suppleants' => array(
					'type' => 'string',
				),
			),
		);

		parent::__construct( $object );
	}

}
