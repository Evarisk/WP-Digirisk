<?php
/**
 * Définition des champs d'une société.
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
 *  Définition des champs d'une société.
 */
class Society_Model extends \eoxia\Post_Model {

	/**
	 * Définition des champs
	 *
	 * @param Object $object La définition des champs.
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 */
	public function __construct( $object ) {

		/**
		 * Les documents et images
		 */
		$this->model['associated_document_id'] = array(
			'type' => 'array',
			'meta_type' => 'multiple',
			'since' => '6.0.0',
			'version' => '6.0.0',
			'child' => array(
				'image' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
					'since' => '6.0.0',
					'version' => '6.0.0',
				),
				'document' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
					'since' => '6.0.0',
					'version' => '6.0.0',
				),
			),
		);

		/**
		 * La clé unique.
		 */
		$this->model['unique_key'] = array(
			'type' => 'string',
			'meta_type' => 'single',
			'field' => '_wpdigi_unique_key',
			'since' => '6.0.0',
			'version' => '6.0.0',
		);

		/**
		 * L'identifiant unique.
		 */
		$this->model['unique_identifier'] = array(
			'type' => 'string',
			'meta_type' => 'single',
			'field' => '_wpdigi_unique_identifier',
			'since' => '6.0.0',
			'version' => '6.0.0',
		);

		/**
		 * Les recommendations associées
		 *
		 * @todo: Est ce utilisé ?
		 */
		$this->model['associated_recommendation'] = array(
			'type' => 'array',
			'meta_type' => 'multiple',
			'since' => '6.0.0',
			'version' => '6.0.0',
		);

		$this->model['siret_id'] = array(
			'description' => 'Le SIRET de la société.',
			'since' => '6.3.0',
			'version' => '6.3.0',
			'type' => 'string',
			'meta_type' => 'single',
			'field' => '_wpdigi_siret_id',
		);

		$this->model['number_of_employees'] = array(
			'description' => 'Le nombre d\'employée dans la société.',
			'since' => '6.3.0',
			'version' => '6.3.0',
			'type' => 'integer',
			'meta_type' => 'single',
			'field' => '_wpdigi_number_of_employees',
		);

		$this->model['contact'] = array(
			'type' => 'array',
			'meta_type' => 'multiple',
			'child' => array(
				'phone' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
				'email' => array(
					'type' => 'string',
				),
				'address_id' => array(
					'type' => 'array',
					'meta_type' => 'multiple',
				),
			),
		);

		parent::__construct( $object );
	}

}
