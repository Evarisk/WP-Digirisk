<?php
/**
 * Classe gérant les catégorie de types de travaux
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.3.3
 * @version 7.3.3
 * @copyright 2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les unités de travail
 */
class Worktype_Category_Class extends \eoxia\Term_Class {

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'W';

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Worktype_Category_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'digi-worktype';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_society_w';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'worktype';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Types de travaux';

	protected function construct() {
		add_action( 'init', array( $this, 'custom_type_creation' ), 1 );
	}

	/**
	 * Création du type d'élément interne de WordPress pour gérer les catégories de risque.
	 *
	 * @since 6.4.0
	 * @version 6.5.0
	 */
	public function custom_type_creation() {
		$labels = array(
			'name'              => __( 'Types de travaux', 'digirisk' ),
			'singular_name'     => __( 'Type of Work', 'digirisk' ),
			'search_items'      => __( 'Search type of work', 'digirisk' ),
			'all_items'         => __( 'All type of work', 'digirisk' ),
			'parent_item'       => null,
			'parent_item_colon' => null,
			'edit_item'         => __( 'Edit Danger category', 'digirisk' ),
			'update_item'       => __( 'Update Danger category', 'digirisk' ),
			'add_new_item'      => __( 'Add New Danger category', 'digirisk' ),
			'new_item_name'     => __( 'New Danger category Name', 'digirisk' ),
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

		register_taxonomy( $this->get_type(), array( 'category-risk' ), $args );
		// Worktype_Category_Default_Data_Class::g()->create();
	}
}

Worktype_Category_Class::g();
