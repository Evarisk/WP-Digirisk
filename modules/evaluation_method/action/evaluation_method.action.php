<?php if ( !defined( 'ABSPATH' ) ) exit;

class evaluation_method_action {
	/**
	* Le constructeur appelle l'action de WordPress: init (Pour déclarer la taxonomy evaluation_method)
	*
	* Appelle également les actions actions personnalisées:
	* wp_ajax_get_scale
	* wp_ajax_save_risk
	*/
  public function __construct() {
		add_action( 'init', array( $this, 'callback_init' ), 1 );
		add_action( 'wp_ajax_get_scale', array( $this, 'ajax_get_scale' ) );
    add_action( 'save_risk_evaluation_method', array( $this, 'callback_save_risk_evaluation_method' ), 10, 2 );
  }

	/**
	* Déclares la taxonomy evaluation_method
	*/
	public function callback_init() {
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
		register_taxonomy( evaluation_method_class::g()->get_taxonomy(), array( risk_class::g()->get_post_type() ), $args );
	}

	/**
* Appelle la méthode get_scale pour avoir le niveau de l'évaluation
*
* array $_POST['list_variable'] La liste des valeurs de la méthode d'évaluation
* @param array $_POST Les données envoyées par le formulaire
*
*/
public function ajax_get_scale() {
	check_ajax_referer( 'get_scale' );
	$list_variable = !empty( $_POST['list_variable'] ) ? (array) $_POST['list_variable'] : array();
	$level = 1;
	if ( !empty( $list_variable ) ) {
		foreach ( $list_variable as $element ) {
			$level *= $element;
		}
	}
	$method_evaluation_digirisk_complex = get_term_by( 'slug', 'evarisk', evaluation_method_class::g()->get_taxonomy() );
	$evaluation_method = evaluation_method_class::g()->get( array( 'id' => $method_evaluation_digirisk_complex->term_id ) );
	$equivalence = $evaluation_method[0]->matrix[$level];
	$scale = scale_util::get_scale( $equivalence );
	wp_send_json_success( array( 'equivalence' => $equivalence, 'scale' => $scale ) );
}

  /**
  * Enregistres la méthode utilisée dans le risque.
	* Ce callback est appelé après le callback "callback_save_risk" de "risk_evaluation_comment_action"
  *
	* int $_POST['method_evaluation_id'] L'ID de la méthode utilisé
  * @param array $_POST Les données envoyées par le formulaire
  *
  */
  public function callback_save_risk_evaluation_method( $risk_id, $risk_evaluation_id ) {
		// todo A déplacer dans la class ?
    $method_evaluation_id = !empty( $_POST['method_evaluation_id'] ) ? (int) $_POST['method_evaluation_id'] : 0;

    if ( $method_evaluation_id === 0 ) {
      wp_send_json_error();
    }

    $risk = risk_class::g()->get( array( 'id' => $risk_id ) );

    $risk[0]->taxonomy['digi-method'][] = $method_evaluation_id;

		risk_class::g()->update( $risk[0] );

		do_action( 'display_risk', $risk[0]->parent_id );
  }
}

new evaluation_method_action();
