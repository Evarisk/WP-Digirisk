<?php
/**
 * Définition des données des terms
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

if ( ! class_exists( '\eoxia\Term_Model' ) ) {

	/**
	 * Définition des données des terms
	 */
	class Term_Model extends Data_Class {

		/**
		 * Définition du modèle principal des taxonomies
		 *
		 * @var array Les champs principaux d'une taxonomie
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
				'field'   => 'term_id',
				'default' => 0,
			);

			$this->schema['type'] = array(
				'type'  => 'string',
				'field' => 'taxonomy',
			);

			$this->schema['term_taxonomy_id'] = array(
				'type'  => 'integer',
				'field' => 'term_taxonomy_id',
			);

			$this->schema['name'] = array(
				'type'  => 'string',
				'field' => 'name',
			);

			$this->schema['description'] = array(
				'type'  => 'string',
				'field' => 'description',
			);

			$this->schema['slug'] = array(
				'type'  => 'string',
				'field' => 'slug',
			);

			$this->schema['parent_id'] = array(
				'type'  => 'integer',
				'field' => 'parent',
			);

			$this->schema['post_id'] = array(
				'type'  => 'integer',
				'field' => 'post_id',
			);

			parent::__construct( $data, $req_method );
		}
	}
}
