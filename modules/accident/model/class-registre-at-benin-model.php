<?php
/**
 * Définition des champs d'un registre accidents travail bénins.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.3.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un registre accidents travail bénins.
 */
class Registre_AT_Benin_Model extends Document_Model {

	/**
	 * Définition des champs 'Accident_Travail_Benin'
	 *
	 * @since 6.3.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['document_meta'] = array(
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
		);

		parent::__construct( $data, $req_method );
	}

}
