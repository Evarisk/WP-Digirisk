<?php
/**
 * Définition du schéma des signalisations.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-only.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.1.5
 * @version   7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Recommendation model class.
 */
class Recommendation_Model extends \eoxia\Post_Model {

	/**
	 * Définition du schéma des recommandations
	 *
	 * @since   6.1.5
	 * @version 7.0.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['recommendation_type'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		$this->schema['efficiency'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
		);

		$this->schema['associated_document_id'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['associated_document_id']['child']['image'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['associated_document_id']['child']['document'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['taxonomy'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['taxonomy']['child']['digi-recommendation-category'] = array(
			'since'      => '6.1.5',
			'version'    => '7.0.0',
			'meta_type'  => 'multiple',
			'type'       => 'array',
			'array_type' => 'integer',
		);

		parent::__construct( $data, $req_method );
	}

}
