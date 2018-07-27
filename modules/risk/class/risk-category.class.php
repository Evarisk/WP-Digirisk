<?php
/**
 * Gestion des catégories de risque.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des catégories de risque.
 */
class Risk_Category_Class extends \eoxia001\Term_Class {
	/**
	 * Nom du modèle à utiliser
	 *
	 * @var string
	 */
	protected $model_name  = '\digi\Risk_Category_Model';

	/**
	 * Type de l'élément dans WordPress.
	 *
	 * @var string
	 */
	protected $taxonomy = 'digi-category-risk';

	/**
	 * Nom du champs (meta) de stockage des données liées
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_dangercategory';

	/**
	 * La route pour la REST API.
	 *
	 * @var string
	 */
	protected $base = 'danger-category';

	/**
	 * La version pour la rest api.
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\digi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier' );

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'CD';

	/**
	 * Le constructeur
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 */
	protected function construct() {
		parent::construct();

		add_action( 'init', array( $this, 'custom_type_creation' ), 1 );
	}

	/**
	 * Création du type d'élément interne de WordPress pour gérer les catégories de risque.
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 */
	function custom_type_creation() {
		$labels = array(
			'name'              => __( 'Danger categories', 'digirisk' ),
			'singular_name'     => __( 'Danger category', 'digirisk' ),
			'search_items'      => __( 'Search Danger categories', 'digirisk' ),
			'all_items'         => __( 'All Danger categories', 'digirisk' ),
			'parent_item'       => null,
			'parent_item_colon' => null,
			'edit_item'         => __( 'Edit Danger category', 'digirisk' ),
			'update_item'       => __( 'Update Danger category', 'digirisk' ),
			'add_new_item'      => __( 'Add New Danger category', 'digirisk' ),
			'new_item_name'     => __( 'New Danger category Name' , 'digirisk' ),
			'menu_name'         => __( 'Danger category', 'digirisk' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => 'danger-category',
			),
		);

		register_taxonomy( $this->taxonomy, array( risk_class::g()->get_post_type() ), $args );
	}
}

Risk_Category_Class::g();
