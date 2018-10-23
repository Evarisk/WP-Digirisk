<?php
/**
 * Gestion des attachments (POST, PUT, GET, DELETE)
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018
 * @package EO_Framework\EO_Model\Class
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Attachment_Class' ) ) {

	/**
	 * Gestion des attachments (POST, PUT, GET, DELETE)
	 */
	class Attachment_Class extends Post_Class {

		/**
		 * Le nom du modèle
		 *
		 * @var string
		 */
		protected $model_name = '\eoxia\Attachment_Model';

		/**
		 * Le type du post
		 *
		 * @var string
		 */
		protected $type = 'attachment';

		/**
		 * Le type du post
		 *
		 * @var string
		 */
		protected $base = 'eo-attachment';

		/**
		 * La clé principale pour post_meta
		 *
		 * @var string
		 */
		protected $meta_key = 'eo_attachment';

		/**
		 * Nom de la taxonomy
		 *
		 * @var string
		 */
		protected $attached_taxonomy_type = 'attachment_category';

		/**
		 * Le nom pour le resgister post type
		 *
		 * @var string
		 */
		protected $post_type_name = 'Attachments';
	}
} // End if().
