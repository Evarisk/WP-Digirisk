<?php
/**
 * Définition des champs d'un groupement.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un groupement.
 */
class Group_Model extends Society_Model {

	/**
	 * Définition des champs
	 *
	 * @param Object $object La définition des champs.
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 */
	public function __construct( $object ) {
		$this->model['user_info'] = array(
			'type' => 'array',
			'meta_type' => 'multiple',
			'child' => array(
				'owner_id' => array(
					'type' => 'integer',
					'meta_type' => 'multiple',
				),
				'affected_id' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
			),
		);

		$this->model['identity'] = array(
			'type' => 'array',
			'meta_type' => 'multiple',
			'child' => array(
				'workforce' => array(
					'type' => 'integer',
					'meta_type' => 'multiple',
				),
				'siren' => array(
					'type' => 'string',
					'meta_type' => 'multiple',
				),
				'siret' => array(
					'type' => 'string',
					'meta_type' => 'multiple',
				),
				'social_activity_number' => array(
					'type' => 'integer',
					'meta_type' => 'multiple',
				),
				'establishment_date' => array(
					'type' => 'string',
					'meta_type' => 'multiple',
				),
			),
		);

		$this->model['owner_id'] = array(
			'description' => 'L\'ID responsable de la société',
			'since'       => '6.4.0',
			'version'     => '6.4.0',
			'type'        => 'integer',
			'meta_type'   => 'single',
			'field'       => '_digi_owner_id',
		);

		parent::__construct( $object );
	}

}
