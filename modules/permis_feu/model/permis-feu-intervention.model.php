<?php
/**
 * Définition des champs d'une intervention, liés à un permis de feu
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     7.3.0
 * @version   7.3.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'une intervention d'un plan de prévention.
 */
class Permis_Feu_Intervention_Model extends \eoxia\Post_Model {

	/**
	 * Le constructeur définit les champs
	 *
	 * @param Permis_Feu_Intervention_Model $object Les données de l'accident.
	 *
	 * @since 7.3.0
	 */
	public function __construct( $object, $req_method ) {


		$this->schema['unite_travail'] = array(
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unite_travail',
		);

		$this->schema['key_unique'] = array(
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_intervention_key_unique',
		);

		$this->schema['action_realise'] = array(
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_action_realise',
		);

		$this->schema['risk'] = array(
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_risk',
		);

		$this->schema['moyen_prevention'] = array(
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_moyen_prevention',
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
