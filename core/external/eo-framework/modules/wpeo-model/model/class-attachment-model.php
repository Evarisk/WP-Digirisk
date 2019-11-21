<?php
/**
 * Définition des données des attachements
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

if ( ! class_exists( '\eoxia\Attachment_Model' ) ) {

	/**
	 * Définition des données des attachements
	 */
	class Attachment_Model extends Post_Model {

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
			$this->schema['mime_type'] = array(
				'type'    => 'string',
				'field'   => 'post_mime_type',
				'context' => array( 'GET' ),
			);

			$this->schema['_wp_attached_file'] = array(
				'type'      => 'string',
				'meta_type' => 'single',
				'field'     => '_wp_attached_file',
			);

			$this->schema['taxonomy'] = array(
				'type'      => 'array',
				'meta_type' => 'multiple',
				'child'     => array(
					Attachment_Class::g()->get_attached_taxonomy() => array(
						'meta_type'  => 'multiple',
						'array_type' => 'integer',
						'type'       => 'array',
					),
				),
			);

			parent::__construct( $data, $req_method );
		}
	}
} // End if().
