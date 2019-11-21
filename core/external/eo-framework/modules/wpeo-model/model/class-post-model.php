<?php
/**
 * Définition des données des posts
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 0.1.0
 * @version 1.0.0
 * @copyright 2015-2018
 * @package EO_Framework\EO_Model\Model
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Post_Model' ) ) {
	/**
	 * Définition des données des posts
	 */
	class Post_Model extends Data_Class {

		/**
		 * Définition du modèle principal des posts
		 *
		 * @var array Les champs principaux des posts
		 */
		protected $schema = array();

		public $data;

		/**
		 * Défini le schéma de WP_Post.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param array $data       Data.
		 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
		 */
		public function __construct( $data = null, $req_method = null ) {
			$this->schema['id'] = array(
				'type'    => 'integer',
				'field'   => 'ID',
				'default' => 0,
			);

			$this->schema['parent_id'] = array(
				'type'  => 'integer',
				'field' => 'post_parent',
			);

			$this->schema['author_id'] = array(
				'type'  => 'integer',
				'field' => 'post_author',
			);

			$this->schema['date'] = array(
				'type'    => 'wpeo_date',
				'field'   => 'post_date',
				'context' => array( 'GET' ),
			);

			$this->schema['date_modified'] = array(
				'type'    => 'wpeo_date',
				'field'   => 'post_modified',
				'context' => array( 'GET' ),
			);

			$this->schema['title'] = array(
				'type'    => 'string',
				'field'   => 'post_title',
				'default' => '',
			);

			$this->schema['slug'] = array(
				'type'  => 'string',
				'field' => 'post_name',
			);

			$this->schema['content'] = array(
				'type'  => 'string',
				'field' => 'post_content',
			);

			$this->schema['status'] = array(
				'type'    => 'string',
				'field'   => 'post_status',
				'default' => 'publish',
			);

			$this->schema['link'] = array(
				'type'  => 'string',
				'field' => 'guid',
			);

			$this->schema['type'] = array(
				'type'  => 'string',
				'field' => 'post_type',
			);

			$this->schema['order'] = array(
				'type'  => 'integer',
				'field' => 'menu_order',
			);

			$this->schema['comment_status'] = array(
				'type'  => 'string',
				'field' => 'comment_status',
			);

			$this->schema['comment_count'] = array(
				'type'  => 'string',
				'field' => 'comment_count',
			);

			$this->schema['thumbnail_id'] = array(
				'type'      => 'integer',
				'meta_type' => 'single',
				'field'     => '_thumbnail_id',
				'default'   => 0,
			);

			parent::__construct( $data, $req_method );
		}
	}
} // End if().
