<?php
/**
 * Définition des champs d'un ODT d'accident de travail bénins.
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
 * Définition des champs d'un ODT d'accident de travail bénins.
 */
class Accident_Travail_Benin_Model extends Document_Model {

	/**
	 * Définition des champs d'un ODT d'accident de travail bénins.
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
			'child'     => array(),
		);

		parent::__construct( $data, $req_method );
	}

}
