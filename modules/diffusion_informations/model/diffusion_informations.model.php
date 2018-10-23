<?php
/**
 * Définition des champs d'un ODT 'diffusion information'.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un ODT 'diffusion information'.
 */
class Diffusion_Informations_Model extends \eoxia001\Post_Model {

	/**
	 * Le constructeur définit les champs
	 *
	 * @param Diffusion_Informations_Model $object Les données de l'accident.
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 */
	public function __construct( $object ) {
		$this->model['document_meta'] = array(
			'type' => 'array',
			'meta_type' => 'single',
			'field' => 'document_meta',
			'child' => array(
				'delegues_du_personnels_date' => array(
					'type' => 'wpeo_date',
				),
				'delegues_du_personnels_titulaires' => array(
					'type' => 'string',
				),
				'delegues_du_personnels_suppleants' => array(
					'type' => 'string',
				),
				'membres_du_comite_entreprise_date' => array(
					'type' => 'wpeo_date',
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
