<?php
/**
 * Définition des champs d'une jointure de causerie.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'une jointure de causerie.
 */
class Causerie_Society_Model extends \eoxia\Post_Model {

	/**
	 * Le constructeur définit les champs
	 *
	 * @param Causerie_Society_Model $object Les données de l'accident.
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 */
	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'unique_key' => array(
				'type' => 'string',
				'meta_type' => 'single',
				'field' => '_wpdigi_unique_key',
			),
			'unique_identifier' => array(
				'type' => 'string',
				'meta_type' => 'single',
				'field' => '_wpdigi_unique_identifier',
			),
			'associated_document_id' => array(
				'type' => 'array',
				'meta_type' => 'multiple',
				'child' => array(
					'image' => array(
						'type' => 'array',
						'meta_type' => 'multiple',
					),
					'document' => array(
						'type' => 'array',
						'meta_type' => 'multiple',
					),
				),
			),
		) );

		parent::__construct( $object );
	}

}
