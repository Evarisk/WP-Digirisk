<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class affichage_legal_a4_model extends document_model {

	/**
	 * Construit le modèle / Fill the model
	 *
	 * @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	 * @param string $meta_key Le nom de la metakey utilisée pour le rangement des données associées à l'élément / The main metakey used to store data associated to current object
	 * @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	 */
	public function __construct( $object ) {
		$this->model['document_meta'] = array(
			'type'				=> 'array',
			'meta_type' 	=> 'single',
			'field'				=> 'document_meta',
			'child' => array(
				'inspection_du_travail_nom' => array(
					'type' => 'string'
				),
				'inspection_du_travail_adresse' => array(
					'type' => 'string'
				),
				'inspection_du_travail_code_postal' => array(
					'type' => 'string'
				),
				'inspection_du_travail_ville' => array(
					'type' => 'string'
				),
				'inspection_du_travail_telephone' => array(
					'type' => 'string'
				),
				'inspection_du_travail_horaire' => array(
					'type' => 'string'
				),
				'service_de_sante_nom' => array(
					'type' => 'string'
				),
				'service_de_sante_adresse' => array(
					'type' => 'string'
				),
				'service_de_sante_code_postal' => array(
					'type' => 'string'
				),
				'service_de_sante_ville' => array(
					'type' => 'string'
				),
				'service_de_sante_telephone' => array(
					'type' => 'string'
				),
				'service_de_sante_horaire' => array(
					'type' => 'string'
				),
				'samu' => array(
					'type' => 'string'
				),
				'police' => array(
					'type' => 'string'
				),
				'pompier' => array(
					'type' => 'string'
				),
				'toute_urgence' => array(
					'type' => 'string'
				),
				'defenseur_des_droits' => array(
					'type' => 'string'
				),
				'anti_poison' => array(
					'type' => 'string'
				),
				'responsable_a_prevenir' => array(
					'type' => 'string'
				),
				'telephone' => array(
					'type' => 'string'
				),
				'emplacement_des_consignes_detaillees' => array(
					'type' => 'string'
				),
				'permanente' => array(
					'type' => 'string'
				),
				'occasionnelle' => array(
					'type' => 'string'
				),
				'intitule' => array(
					'type' => 'string'
				),
				'lieu_modalite' => array(
					'type' => 'string'
				),
				'lieu_affichage' => array(
					'type' => 'string'
				),
				'modalite_access' => array(
					'type' => 'string'
				),
				'lundi_matin' => array(
					'type' => 'string'
				),
				'mardi_matin' => array(
					'type' => 'string'
				),
				'mercredi_matin' => array(
					'type' => 'string'
				),
				'jeudi_matin' => array(
					'type' => 'string'
				),
				'vendredi_matin' => array(
					'type' => 'string'
				),
				'samedi_matin' => array(
					'type' => 'string'
				),
				'dimanche_matin' => array(
					'type' => 'string'
				),
				'lundi_aprem' => array(
					'type' => 'string'
				),
				'mardi_aprem' => array(
					'type' => 'string'
				),
				'mercredi_aprem' => array(
					'type' => 'string'
				),
				'jeudi_aprem' => array(
					'type' => 'string'
				),
				'vendredi_aprem' => array(
					'type' => 'string'
				),
				'samedi_aprem' => array(
					'type' => 'string'
				),
				'dimanche_aprem' => array(
					'type' => 'string'
				),
				'modalite_information_ap' => array(
					'type' => 'string'
				)
			)
		);

		parent::__construct( $object );
	}

}
