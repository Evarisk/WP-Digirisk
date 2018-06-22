<?php
/**
 * Définition du schéma des catégories de signalisation.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-only.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.1.6
 * @version   7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Recommendation category class.
 */
class Recommendation_Category_Model extends \eoxia\Term_Model {

	/**
	 * Définition du schéma des recommandations.
	 *
	 * @since 6.1.6
	 * @version 7.0.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
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
