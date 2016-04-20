<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * File for digirisk datas transfer control class definition
 *
 * @author Development team <dev@eoxia.com>
 * @version 1.0
 *
 */

/**
 * Class for digirisk datas transfer control
 *
 * @author Development team <dev@eoxia.com>
 * @version 1.0
 *
 */
class Digi_odistraction_controller_01 {

	function __construct() {
		add_action( 'digi-extra-module-activation', array( $this, 'activation' ) );
		add_action( 'generate_rewrite_rules', array( $this, 'add_rewrite_rules') );
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );
		add_filter( 'query_vars', array( $this, 'query_vars') );
	}

	function activation() {
		global $wp_rewrite;
		add_rewrite_rule('^digirisk/?$','index.php?digirisk=1','top');
	}

	function add_rewrite_rules( $wp_rewrite ) {
		$rules = array(
     		'^digirisk/?$' => 'index.php?digirisk=1',
		);

		$rules = apply_filters( 'eo_extend_routes', $rules );
		$wp_rewrite->rules = $rules + (array)$wp_rewrite->rules;
	}

	function query_vars($public_query_vars){
		array_push($public_query_vars, 'digirisk');
		return $public_query_vars;
	}

	/**
	 * Output the POS template
	 */
	public function template_redirect() {
		global $wp;

		if( isset( $wp->query_vars['digirisk'] ) && $wp->query_vars['digirisk'] == 1 ){
			require_once( wpdigi_utils::get_template_part( DIGI_NODIST_DIR, DIGI_NODIST_TEMPLATES_MAIN_DIR, 'backend', 'digirisk' ) );
			exit;
		}
		return;
	}

}
