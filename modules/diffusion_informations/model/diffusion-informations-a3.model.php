<?php
/**
 * Définition du schéma des diffusions d'information au format A3.
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
 * Définition du schéma des diffusions d'information au format A3.
 */
class Diffusion_Informations_A3_Model extends \eoxia\Post_Model {

	/**
	 * Définition du schéma des diffusions d'information au format A3.
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
			'version'   => '6.5.0',
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
		);

		$this->schema['unique_key'] = array(
			'since'     => '6.4.0',
			'version'   => '6.4.0',
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_key',
			'default'   => '',
		);

		$this->schema['unique_identifier'] = array(
			'since'     => '6.4.0',
			'version'   => '6.4.0',
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_identifier',
			'default'   => '',
		);

		parent::__construct( $data, $req_method );
	}

}
