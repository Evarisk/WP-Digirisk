<?php if ( !defined( 'ABSPATH' ) ) exit;

class evaluation_method_action {
  public function __construct() {
		add_action( 'init', array( $this, 'callback_init' ), 1 );
    add_action( 'wp_ajax_save_risk', array( $this, 'callback_save_risk' ), 4 );
  }

	public function callback_init() {
		global $wpdigi_risk_ctr;
		global $evaluation_method_class;
		$labels = array(
			'name'              => __( 'Evaluation methods', 'digirisk' ),
			'singular_name'     => __( 'Evaluation method', 'digirisk' ),
			'search_items'      => __( 'Search evaluation methods', 'digirisk' ),
			'all_items'         => __( 'All evaluation methods', 'digirisk' ),
			'parent_item'       => __( 'Parent evaluation method', 'digirisk' ),
			'parent_item_colon' => __( 'Parent evaluation method:', 'digirisk' ),
			'edit_item'         => __( 'Edit evaluation method', 'digirisk' ),
			'update_item'       => __( 'Update evaluation method', 'digirisk' ),
			'add_new_item'      => __( 'Add New evaluation method', 'digirisk' ),
			'new_item_name'     => __( 'New evaluation method Name' , 'digirisk'),
			'menu_name'         => __( 'Evaluation method', 'digirisk' ),
		);
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'evaluation-method' ),
		);
		register_taxonomy( $evaluation_method_class->get_taxonomy(), array( $wpdigi_risk_ctr->get_post_type() ), $args );
	}

  /**
  * Enregistres la méthode utilisée dans le risque.
	* Ce callback est appelé après le callback callback_save_risk de risk_evaluation_comment_action
  *
  * @param int $_POST['method_evaluation_id'] L'id de la méthode utilisée
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  *
  * @return void
  */
  public function callback_save_risk() {
    check_ajax_referer( 'save_risk' );

		global $wpdigi_risk_ctr;

    $method_evaluation_id = !empty( $_POST['method_evaluation_id'] ) ? (int) $_POST['method_evaluation_id'] : 0;

    if ( $method_evaluation_id === 0 ) {
      wp_send_json_error();
    }

    $risk_id = $wpdigi_risk_ctr->get_last_entry();
    $risk = $wpdigi_risk_ctr->show( $risk_id );

    $risk->taxonomy['digi-method'][] = $method_evaluation_id;

    wp_send_json_success();
  }
}

new evaluation_method_action();
