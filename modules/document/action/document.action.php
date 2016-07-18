<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier de controlle des requêtes pour les documents
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe de controlle des requêtes pour les documents
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class document_action {

	/**
	 * Le constructeur appelle l'action personnalisé wp_ajax_wpdigi_delete_sheet
	 */
	function __construct() {
		/**	Define taxonomy for attachment categories	*/
		add_action( 'init', array( $this, 'custom_type_creation' ), 5  );

    add_action( 'wp_ajax_wpdigi_delete_sheet', array( $this, 'ajax_delete_sheet' ) );
  }

	/**
	 * Création du type d'élément interne a wordpress pour gérer les catégories de documents / Create wordpress element type for managing attachment categories
	 */
	public function custom_type_creation() {
		$labels = array(
			'name'              => 'Categories',
			'singular_name'     => 'Category',
			'search_items'      => 'Search Categories',
			'all_items'         => 'All Categories',
			'parent_item'       => 'Parent Category',
			'parent_item_colon' => 'Parent Category:',
			'edit_item'         => 'Edit Category',
			'update_item'       => 'Update Category',
			'add_new_item'      => 'Add New Category',
			'new_item_name'     => 'New Category Name',
			'menu_name'         => 'Category',
		);

		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'query_var' => 'true',
			'rewrite' => 'true',
			'show_admin_column' => 'true',
		);

		register_taxonomy( document_class::get()->attached_taxonomy_type, document_class::get()->post_type, $args );
	}

	/**
	* Supprimes un document dans une societé
	*/
  public function ajax_delete_sheet() {
		// Todo déplacer cette fonction dans la class
		if ( true !== is_int( (int) $_POST['parent_id'] ) )
      wp_send_json_error();
    else
      $parent_id = (int) $_POST['parent_id'];

    if ( true !== is_int( (int) $_POST['element_id'] ) )
      wp_send_json_error();
    else
      $element_id = (int) $_POST['element_id'];

    $global = sanitize_text_field( $_POST['global'] );

    global ${$global};
    $parent_element = ${$global}->show( $parent_id );

    if ( $parent_element->id == 0 || empty( $parent_element->option['associated_document_id']['document'] ) )
      wp_send_json_error();

    $key = array_search( $element_id, $parent_element->option['associated_document_id']['document'] );

    if ( $key < 0 )
      wp_send_json_error();

    unset( $parent_element->option['associated_document_id']['document'][$key] );

    ${$global}->update( $parent_element );

    wp_send_json_success();
  }
}

new document_action();
