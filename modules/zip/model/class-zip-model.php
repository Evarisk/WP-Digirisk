<?php
/**
 * Définition du modèle d'un ZIP.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Le modèle du ZIP
 */
class ZIP_Model extends \eoxia\Post_Model {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.1
	 *
	 * @param ZIP_Model $data       L'objet zip.
	 * @param string    $req_method Peut être GET, POST, PUT.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->model['list_generation_results'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
		);

		$this->schema['path'] = array(
			'since'     => '7.0.0',
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_path',
		);

		parent::__construct( $data, $req_method );
	}
}
