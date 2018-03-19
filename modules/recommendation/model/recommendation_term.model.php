<?php
/**
 * Définition du schéma des recommandations.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.6
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition du schéma des recommandations
 */
class Recommendation_Term_Model extends \eoxia\Term_Model {

	/**
	 * Définition du schéma des recommandations.
	 *
	 * @since 6.1.6
	 * @version 6.1.6
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['unique_key'] = array(
			'since'     => '6.1.6',
			'version'   => '6.1.6',
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_key',
		);

		$this->schema['unique_identifier'] = array(
			'since'     => '6.1.6',
			'version'   => '6.1.6',
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_identifier',
		);

		$this->schema['type'] = array(
			'since'     => '6.1.6',
			'version'   => '6.1.6',
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		$this->schema['thumbnail_id'] = array(
			'since'     => '6.1.6',
			'version'   => '6.1.6',
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_thumbnail_id',
		);

		parent::__construct( $data, $req_method );
	}

}
