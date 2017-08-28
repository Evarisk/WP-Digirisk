<?php
/**
 * Définition des champs d'un accident.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Définition des champs d'un accident.
 */
class Accident_Model extends \eoxia\Post_Model {

	/**
	 * Le constructeur définit les champs
	 *
	 * @param Accident_Model $object Les données de l'accident.
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 */
	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'unique_key' => array(
				'type' 				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> '_wpdigi_unique_key',
			),
			'unique_identifier' => array(
				'type' 				=> 'string',
				'meta_type'		=> 'single',
				'field'				=> '_wpdigi_unique_identifier',
			),
			'risk_id' => array(
				'type'				=> 'integer',
				'meta_type'	=> 'multiple',
			),
			'accident_date' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
			),
			'victim_identity' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
			),
			'registration_date_in_register' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
			),
			'place' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
			),
			'location_of_lesions' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
			),
			'name_and_address_of_witnesses' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
			),
			'name_and_address_of_third_parties_involved' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
			),
			'observation' => array(
				'type'				=> 'string',
				'meta_type'		=> 'multiple',
			),
			'name_and_signature_of_the_caregiver_id' => array(
				'type'				=> 'array',
				'meta_type'	=> 'multiple',
			),
			'signature_of_the_victim' => array(
				'type'				=> 'array',
				'meta_type'	=> 'multiple',
			),
		) );

		parent::__construct( $object );
	}

}
