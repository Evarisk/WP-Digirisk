<?php
/**
 * Définition des champs d'un zip.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1
 * @version 6.2.1
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Le modèle du ZIP
 */
class ZIP_Model extends \eoxia\Post_Model {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.1
	 * @version 6.2.1
	 *
	 * @param ZIP_Model $object L'objet zip.
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
