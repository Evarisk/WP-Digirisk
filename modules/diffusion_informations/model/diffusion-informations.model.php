<?php
/**
 * Définition du schéma des diffusions d'information.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition du schéma des diffusions d'information.
 */
class Diffusion_Informations_Model extends \eoxia\Post_Model {

	/**
	 * Définition du schéma des diffusions d'information.
	 *
	 * @since 6.4.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['document_meta'] = array(
			'since'     => '6.4.0',
			'version'   => '6.4.0',
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
			'child'     => array(),
		);

		$this->schema['document_meta']['child']['delegues_du_personnels_date'] = array(
			'since'   => '6.4.0',
			'version' => '6.5.0',
			'type'    => 'wpeo_date',
			'context' => array( 'GET' ),
		);

		$this->schema['document_meta']['child']['delegues_du_personnels_titulaires'] = array(
			'since'   => '6.4.0',
			'version' => '6.4.0',
			'type'    => 'string',
			'default' => '',
		);

		$this->schema['document_meta']['child']['delegues_du_personnels_suppleants'] = array(
			'since'   => '6.4.0',
			'version' => '6.4.0',
			'type'    => 'string',
			'default' => '',
		);

		$this->schema['document_meta']['child']['membres_du_comite_entreprise_date'] = array(
			'since'   => '6.4.0',
			'version' => '6.5.0',
			'type'    => 'wpeo_date',
			'context' => array( 'GET' ),
		);

		$this->schema['document_meta']['child']['membres_du_comite_entreprise_titulaires'] = array(
			'since'   => '6.4.0',
			'version' => '6.4.0',
			'type'    => 'string',
			'default' => '',
		);

		$this->schema['document_meta']['child']['membres_du_comite_entreprise_suppleants'] = array(
			'since'   => '6.4.0',
			'version' => '6.4.0',
			'type'    => 'string',
			'default' => '',
		);

		parent::__construct( $data, $req_method );
	}
}
