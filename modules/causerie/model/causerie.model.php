<?php
/**
 * Définition des champs d'un causerie.
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
 * Définition des champs d'un causerie.
 */
class Causerie_Model extends \eoxia\Post_Model {

	/**
	 * Le constructeur définit les champs
	 *
	 * @param Causerie_Model $object Les données de l'accident.
	 *
	 * @since 6.6.0
	 */
	public function __construct( $object, $req_method ) {
		$this->schema['number_time_realized'] = array(
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_number_time_realized',
		);

		$this->schema['number_formers'] = array(
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_number_formers',
		);

		$this->schema['number_participants'] = array(
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_number_participants',
		);

		$this->schema['last_date_realized'] = array(
			'type'      => 'wpeo_date',
			'meta_type' => 'single',
			'field'     => '_wpdigi_last_date_realized',
			'context'   => array( 'GET' ),
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

		$this->schema['associated_document_id'] = array(
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
		);

		$this->schema['document_meta'] = array(
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
		);

		parent::__construct( $object, $req_method );
	}

}
