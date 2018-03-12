<?php
/**
 * Définition du modèle du listing de risque.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition du modèle du listing de risque.
 */
class Listing_Risk_Model extends Document_Model {

	/**
	 * Le constructeur définis le schéma.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param object $object L'objet courant.
	 */
	public function __construct( $object ) {
		$this->model['document_meta'] = array(
			'type'      => 'array',
			'meta_type' => 'single',
			'field'     => 'document_meta',
		);

		parent::__construct( $object );
	}

}
