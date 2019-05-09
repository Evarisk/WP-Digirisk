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
	 */
	public function __construct( $object, $req_method ) {
		$this->schema['second_unique_key'] = array(
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_second_unique_key',
		);

		$this->schema['second_identifier'] = array(
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_second_identifier',
		);

		$this->schema['current_step'] = array(
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_current_step',
			'default' => 1,
		);

		$this->schema['date_start'] = array(
			'type'      => 'wpeo_date',
			'meta_type' => 'single',
			'field'     => '_wpdigi_date_start',
			'context'   => array( 'GET' ),
		);

		$this->schema['date_end'] = array(
			'type'      => 'wpeo_date',
			'meta_type' => 'single',
			'field'     => '_wpdigi_date_end',
			'context'   => array( 'GET' ),
		);

		$this->schema['former'] = array(
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
					'type'    => 'wpeo_date',
					'context' => array( 'GET' ),
				),
			),
		);

		$this->schema['participants'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
		);


		$this->schema['taxonomy'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(
				'digi-category-risk' => array(
					'meta_type'  => 'multiple',
					'array_type' => 'integer',
					'type'       => 'array',
				),
			),
		);

		parent::__construct( $object, $req_method );
	}

}
