<?php
/**
 * Définition des données des commentaires
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

if ( ! class_exists( '\eoxia\Comment_Model' ) ) {
	/**
	 * Définition des données des commentaires
	 */
	class Comment_Model extends Constructor_Data_Class {

		/**
		 * Définition du modèle principal des commentaires
		 *
		 * @var array Les champs principaux des commentaires
		 */
		protected $model = array(
			'id' => array(
				'type' => 'integer',
				'field' => 'comment_ID',
			),
			'parent_id' => array(
				'type' => 'integer',
				'field' => 'comment_parent',
			),
			'post_id' => array(
				'type' => 'integer',
				'field' => 'comment_post_ID',
			),
			'date' => array(
				'type' => 'wpeo_date',
				'field' => 'comment_date',
			),
			'author_id' => array(
				'type' => 'integer',
				'field' => 'user_id',
			),
			'author_nicename' => array(
				'type' => 'string',
				'field' => 'comment_author',
			),
			'author_email' => array(
				'type' => 'string',
				'field' => 'comment_author_email',
			),
			'author_ip' => array(
				'type' => 'string',
				'field' => 'comment_author_IP',
			),
			'content' => array(
				'type' => 'string',
				'field' => 'comment_content',
			),
			'status' => array(
				'type' => 'string',
				'field' => 'comment_approved',
			),
			'type' => array(
				'type' => 'string',
				'field' => 'comment_type',
			),
		);

		/**
		 * Le constructeur
		 *
		 * @since 1.0.0
		 * @version 1.5.0
		 *
		 * @param array $data Les données de l'objet.
		 */
		public function __construct( $data ) {
			$this->model['author_id']['bydefault'] = get_current_user_id();

			parent::__construct( $data );
		}
	}
} // End if().
