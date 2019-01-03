<?php
/**
 * Définition des données des commentaires
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

if ( ! class_exists( '\eoxia\Comment_Model' ) ) {
	/**
	 * Définition des données des commentaires
	 */
	class Comment_Model extends Data_Class {

		/**
		 * Définition du modèle principal des commentaires
		 *
		 * @var array Les champs principaux des commentaires
		 */
		protected $schema = array();

		/**
		 * Le constructeur
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param array $data       Les données de l'objet.
		 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
		 */
		public function __construct( $data = null, $req_method = null ) {
			$this->schema['id'] = array(
				'type'    => 'integer',
				'field'   => 'comment_ID',
				'default' => 0,
			);

			$this->schema['parent_id'] = array(
				'type'    => 'integer',
				'field'   => 'comment_parent',
				'default' => 0,
			);

			$this->schema['post_id'] = array(
				'type'    => 'integer',
				'field'   => 'comment_post_ID',
				'default' => 0,
			);

			$this->schema['date'] = array(
				'type'    => 'wpeo_date',
				'context' => array( 'GET' ),
				'field'   => 'comment_date',
			);

			$this->schema['author_id'] = array(
				'type'    => 'integer',
				'field'   => 'user_id',
				'default' => get_current_user_id(),
			);

			$this->schema['author_nicename'] = array(
				'type'  => 'string',
				'field' => 'comment_author',
			);

			$this->schema['author_email'] = array(
				'type'  => 'string',
				'field' => 'comment_author_email',
			);

			$this->schema['author_url'] = array(
				'type'  => 'string',
				'field' => 'comment_author_url',
			);

			$this->schema['author_ip'] = array(
				'type'  => 'string',
				'field' => 'comment_author_IP',
			);

			$this->schema['content'] = array(
				'type'     => 'string',
				'field'    => 'comment_content',
				'required' => true,
				'default'  => '',
			);

			$this->schema['status'] = array(
				'type'    => 'string',
				'field'   => 'comment_approved',
				'default' => '1',
			);

			$this->schema['agent'] = array(
				'type'    => 'string',
				'field'   => 'comment_agent',
				'default' => isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '',
			);

			$this->schema['type'] = array(
				'type'     => 'string',
				'field'    => 'comment_type',
				'required' => true,
			);

			parent::__construct( $data, $req_method );
		}
	}
} // End if().
