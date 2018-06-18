<?php
/**
 * Définition des champs d'un causerie dans son état "intervention".
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un causerie dans son état "intervention".
 */
class Causerie_Intervention_Model extends Causerie_Model {

	/**
	 * Le constructeur définit les champs
	 *
	 * @param Causerie_Model $object Les données de la causerie dans son état "final".
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
			'second_unique_key'      => array(
				'type'      => 'string',
				'meta_type' => 'single',
				'field'     => '_wpdigi_second_unique_key',
			),
			'second_identifier'      => array(
				'type'      => 'string',
				'meta_type' => 'single',
				'field'     => '_wpdigi_second_identifier',
			),
			'current_step'           => array(
				'type'      => 'integer',
				'meta_type' => 'single',
				'field'     => '_wpdigi_current_step',
				'bydefault' => 1,
			),
			'date_start'             => array(
				'type'      => 'wpeo_date',
				'meta_type' => 'single',
				'field'     => '_wpdigi_date_start',
			),
			'date_end'               => array(
				'type'      => 'wpeo_date',
				'meta_type' => 'single',
				'field'     => '_wpdigi_date_end',
			),
			'former'                 => array(
				'type'      => 'array',
				'meta_type' => 'multiple',
				'child'     => array(
					'user_id'        => array(
						'type' => 'integer',
					),
					'signature_id'   => array(
						'type' => 'integer',
					),
					'signature_date' => array(
						'type' => 'wpeo_date',
					),
				),
			),
			'participants'           => array(
				'type'      => 'array',
				'meta_type' => 'multiple',
			),
			'associated_document_id' => array(
				'type'      => 'array',
				'meta_type' => 'multiple',
				'child'     => array(
					'image'    => array(
						'type'      => 'array',
						'meta_type' => 'multiple',
					),
					'document' => array(
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
		) );

		parent::__construct( $object );
	}

}
