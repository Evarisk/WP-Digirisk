<?php
/**
 * Définition du modèle d'une catégorie de risque.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
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
 * Définition du modèle d'une catégorie de risque.
 */
class Risk_Category_Model extends \eoxia001\Term_Model {

	/**
	 * Le constructeur.
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 *
	 * @param Object $object L'objet.
	 */
	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'status' => array(
				'type' => 'string',
				'meta_type' => 'single',
				'field' => '_wpdigi_status',
				'bydefault' => '',
			),
			'unique_key' => array(
				'type' => 'string',
				'meta_type' => 'single',
				'field' => '_wpdigi_unique_key',
				'bydefault' => '',
			),
			'unique_identifier' => array(
				'type' => 'string',
				'meta_type' => 'multiple',
				'bydefault' => '',
			),
			'thumbnail_id' => array(
				'type' => 'integer',
				'meta_type' => 'single',
				'field' => '_thumbnail_id',
				'bydefault' => 0,
			),
			'position' => array(
				'type' => 'integer',
				'meta_type' => 'single',
				'field' => '_position',
				'bydefault' => 1,
			),
		) );

		parent::__construct( $object );
	}

}
