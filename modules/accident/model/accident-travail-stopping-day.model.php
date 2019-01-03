<?php
/**
 * Définition des champs d'un accident "stoppping day"
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un accident "stoppping day"
 */
class Accident_Travail_Stopping_Day_Model extends \eoxia\Post_Model {

	/**
	 * Le constructeur définit les champs
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 *
	 * @since 6.4.0
	 * @version 6.5.0
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['unique_key'] = array(
			'since'     => '6.4.0',
			'version'   => '6.4.0',
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_key',
		);

		$this->schema['unique_identifier'] = array(
			'since'     => '6.4.0',
			'version'   => '6.4.0',
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_identifier',
		);

		$this->schema['number_day'] = array(
			'since'     => '6.4.0',
			'version'   => '6.4.0',
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_number_day',
		);

		$this->schema['associated_document_id'] = array(
			'since'     => '6.4.0',
			'version'   => '6.4.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['associated_document_id']['child']['document'] = array(
			'since'     => '6.4.0',
			'version'   => '6.4.0',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		parent::__construct( $data, $req_method );
	}

}
