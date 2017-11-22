<?php
/**
 * Définition des champs d'un accident "stoppping day"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs d'un accident "stoppping day"
 */
class Accident_Travail_Stopping_Day_Model extends \eoxia\Post_Model {

	/**
	 * Le constructeur définit les champs
	 *
	 * @param Accident_Model $object Les données de l'accident.
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 */
	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'unique_key' => array(
				'type' => 'string',
				'meta_type' => 'single',
				'field' => '_wpdigi_unique_key',
			),
			'unique_identifier' => array(
				'type' => 'string',
				'meta_type' => 'single',
				'field' => '_wpdigi_unique_identifier',
			),
			'number_day' => array(
				'type' => 'integer',
				'meta_type' => 'single',
				'field' => '_wpdigi_number_day',
			),
			'associated_document_id' => array(
				'type' => 'array',
				'meta_type' => 'multiple',
				'child' => array(
					'image' => array(
						'type' => 'array',
						'meta_type' => 'multiple',
					),
				),
			),
		) );

		parent::__construct( $object );
	}

}
