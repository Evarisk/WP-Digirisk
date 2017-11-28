<?php
/**
 * Définition du modèle pour la diffusion d'informations en A3
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.10.0
 * @version 6.2.10.0
 * @copyright 2015-2017 Evarisk
 * @package legal_display
 * @subpackage model
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Définition du modèle pour la diffusion d'informations en A3
 */
class Diffusion_Informations_A3_Model extends Document_Model {

	/**
	 * Définition du modèle.
	 *
	 * @param Array $object Le tableau définissant les données.
	 *
	 * @since 6.2.10.0
	 * @version 6.2.10.0
	 */
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
