<?php
/**
 * Définition des données des ODT
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018
 * @package EO_Framework\EO_Model\Model
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\ODT_Model' ) ) {

	/**
	 * Définition des données des ODT
	 */
	class ODT_Model extends Attachment_Model {

		/**
		 * Définition du modèle principal des attachements
		 *
		 * @var array Les champs principaux des attachements
		 */
		protected $schema = array();

		/**
		 * Défini le schéma de WP_Post de type attachment.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param array $data       Data.
		 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
		 */
		public function __construct( $data = null, $req_method = null ) {
			$this->schema['model_path'] = array(
				'type'      => 'string',
				'meta_type' => 'single',
				'field'     => 'fp_model_path',
			);

			$this->schema['model_id'] = array(
				'since'     => '6.0.0',
				'version'   => '6.0.0',
				'type'      => 'integer',
				'meta_type' => 'single',
				'field'     => '_wpdigi_model_id',
			);

			$this->schema['path'] = array(
				'since'     => '6.0.0',
				'version'   => '6.0.0',
				'type'      => 'string',
				'meta_type' => 'single',
				'field'     => '_wpdigi_path',
			);

			$this->schema['file_generated'] = array(
				'since'     => '7.0.0',
				'field'     => '_file_generated',
				'type'      => 'boolean',
				'meta_type' => 'single',
				'default'   => false,
			);

			parent::__construct( $data, $req_method );
		}
	}
} // End if().
