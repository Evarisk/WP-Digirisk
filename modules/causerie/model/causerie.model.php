<?php
/**
 * Définition des champs d'un causerie.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un causerie.
 */
class Causerie_Model extends \eoxia\Post_Model {

	/**
	 * Le constructeur définit les champs
	 *
	 * @param Causerie_Model $object Les données de l'accident.
	 *
	 * @since 6.5.0
	 * @version 6.6.0
	 */
	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'unique_key'             => array(
				'type'      => 'string',
				'meta_type' => 'single',
				'field'     => '_wpdigi_unique_key',
			),
			'unique_identifier'      => array(
				'type'      => 'string',
				'meta_type' => 'single',
				'field'     => '_wpdigi_unique_identifier',
			),
			'number_time_realized'   => array(
				'type'      => 'integer',
				'meta_type' => 'single',
				'field'     => '_wpdigi_number_time_realized',
			),
			'number_formers'         => array(
				'type'      => 'integer',
				'meta_type' => 'single',
				'field'     => '_wpdigi_number_formers',
			),
			'number_participants'    => array(
				'type'      => 'integer',
				'meta_type' => 'single',
				'field'     => '_wpdigi_number_participants',
			),
			'last_date_realized'     => array(
				'type'      => 'wpeo_date',
				'meta_type' => 'single',
				'field'     => '_wpdigi_last_date_realized',
			),
			'associated_document_id' => array(
				'type'      => 'array',
				'meta_type' => 'multiple',
				'child'     => array(
					'image' => array(
						'type'      => 'array',
						'meta_type' => 'multiple',
					),
				),
			),
			'taxonomy'               => array(
				'type'      => 'array',
				'meta_type' => 'multiple',
				'child'     => array(
					'digi-category-risk' => array(
						'meta_type'  => 'multiple',
						'array_type' => 'integer',
						'type'       => 'array',
					),
				),
			),
			'document_meta'          => array(
				'type'      => 'array',
				'meta_type' => 'single',
				'field'     => 'document_meta',
			),
		) );

		parent::__construct( $object );
	}

}
