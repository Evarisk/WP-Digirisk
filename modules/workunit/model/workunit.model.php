<?php
/**
 * Définition des champs d'une unité de travail.
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
 * Définition des champs d'une unité de travail.
 */
class Workunit_Model extends Society_Model {

	/**
	 * Définition des champs
	 *
	 * @param Object $object La définition des champs.
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 */
	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'user_info' => array(
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
			),
			'identity' => array(
				'type' => 'array',
				'meta_type' => 'multiple',
				'child' => array(
					'workforce' => array(
						'type' => 'integer',
					),
				),
			),
		) );

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
