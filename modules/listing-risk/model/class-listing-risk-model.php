<?php
/**
 * Définition du modèle du listing de risque.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.5.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Listing Risk Model class.
 */
class Listing_Risk_Model extends Document_Model {

	/**
	 * Constructor.
	 *
	 * @since 6.5.0
	 */
	protected function construct() {
		$this->schema['document_meta'] = array(
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
			'child'     => array(
				'identifiantElement' => array(
					'type' => 'string',
				),
			),
		);

		parent::__construct( $data, $req_method );
	}
}
