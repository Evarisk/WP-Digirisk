<?php
/**
 * Définition des données des posts
 *
 * @author Jimmy Latour <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.5.0
 * @copyright 2015-2017
 * @package WPEO_Model
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Post_Model' ) ) {
	/**
	 * Définition des données des posts
	 */
	class Post_Model extends Constructor_Data_Class {

		/**
		 * Définition du modèle principal des posts
		 *
		 * @var array Les champs principaux des posts
		 */
		protected $model = array(
			'id' => array(
				'type' => 'integer',
				'field' => 'ID',
			),
			'parent_id' => array(
				'type' => 'integer',
				'field' => 'post_parent',
			),
			'author_id' => array(
				'type' => 'integer',
				'field' => 'post_author',
			),
			'date' => array(
				'type' => 'wpeo_date',
				'field' => 'post_date',
			),
			'date_modified' => array(
				'type' => 'wpeo_date',
				'field' => 'post_modified',
			),
			'date_input' => array(
				'type' => 'array',
			),
			'date_human_readable' => array(
				'type' => 'string',
			),
			'title' => array(
				'type' => 'string',
				'field' => 'post_title',
			),
			'slug' => array(
				'type' => 'string',
				'field' => 'post_name',
			),
			'content' => array(
				'type' => 'string',
				'field' => 'post_content',
			),
			'status' => array(
				'type' => 'string',
				'field' => 'post_status',
				'bydefault' => 'publish',
			),
			'link' => array(
				'type' => 'string',
				'field' => 'guid',
			),
			'type' => array(
				'type' => 'string',
				'field' => 'post_type',
			),
			'order' => array(
				'type' => 'int',
				'field' => 'menu_order',
			),
			'comment_status' => array(
				'type' => 'string',
				'field' => 'comment_status',
			),
			'comment_count' => array(
				'type' => 'int',
				'field' => 'comment_count',
			),
			'thumbnail_id' => array(
				'type' => 'int',
				'meta_type' => 'single',
				'field' => '_thumbnail_id',
			),
		);

		/**
		 * Gestion des valeurs par défaut.
		 *
		 * @param array $data Les données.
		 *
		 * @since 1.0.0
		 * @version 1.5.0
		 */
		public function __construct( $data ) {
			$this->model['author_id']['bydefault'] = get_current_user_id();

			parent::__construct( $data );
		}
	}
} // End if().
