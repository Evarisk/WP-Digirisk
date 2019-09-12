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

		$this->schema['unique_identifier_int'] = array(
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_identifier_prevention_int',
			'default'   => 0
		);

		$this->schema['is_end'] = array(
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_prevention_prevention_is_end',
			'default' 	=> 0,
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

		$this->schema['date_end__is_define'] = array(
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_prevention_date_end_exist',
			'default'   => 'undefined'
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
				'phone_nbr'        => array(
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

		$this->schema['more_than_400_hours'] = array(
			'type'      => 'integer',
			'meta_type' => 'multiple',
			'default' => 0,
		);

		$this->schema['imminent_danger'] = array(
			'type'      => 'integer',
			'meta_type' => 'multiple',
			'default' => 0,
		);

		$this->schema['society_outside_name'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => 'Entreprise Exterieur',
		);

		$this->schema['society_outside_siret'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
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
