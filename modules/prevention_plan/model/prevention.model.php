<?php
/**
 * Définition des champs d'un plan de prévention.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un plan de prévention.
 */
class Prevention_Model extends \eoxia\Post_Model {

	/**
	 * Le constructeur définit les champs
	 *
	 * @param Prevention_Model $object Les données de l'accident.
	 *
	 * @since 6.6.0
	 */
	public function __construct( $object, $req_method ) {

		$this->schema['step'] = array(
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_prevention_prevention_step',
			'default' => 1,
		);

		$this->schema['date_start'] = array(
			'type'      => 'wpeo_date',
			'meta_type' => 'single',
			'field'     => '_wpdigi_prevention_date_start',
			'context'   => array( 'GET' ),
		);

		$this->schema['date_end'] = array(
			'type'      => 'wpeo_date',
			'meta_type' => 'single',
			'field'     => '_wpdigi_prevention_date_end',
			'context'   => array( 'GET' ),
		);

		$this->schema['date_end_define'] = array(
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_prevention_date_end_exist',
			'default'   => 0
		);

		$this->schema['date_closure'] = array(
			'type'      => 'wpeo_date',
			'meta_type' => 'single',
			'field'     => '_wpdigi_prevention_date_closure',
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

		$this->schema['maitre_oeuvre'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(
				'user_id'        => array(
					'type' => 'integer',
				),
				'phone'        => array(
					'type' => 'string',
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

		$this->schema['intervenant_exterieur'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(
				'firstname'        => array(
					'type' => 'string',
				),
				'lastname'        => array(
					'type' => 'string',
				),
				'phone'        => array(
					'type' => 'string',
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

		$this->schema['intervenants'] = array(
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
