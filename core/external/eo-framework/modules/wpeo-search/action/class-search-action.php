<?php
/**
 * Handle action for search module.
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright (c) 2015-2018 Eoxia <dev@eoxia.com>.
 *
 * @license GPLv3 <https://spdx.org/licenses/GPL-3.0-or-later.html>
 *
 * @package EO_Framework\EO_Search\Action
 *
 * @since 1.1.0
 */

namespace eoxia;

defined( 'ABSPATH' ) || exit;

/**
 * Search Action Class.
 */
class Search_Action {

	/**
	 * Constructor.
	 *
	 * @since 1.1.0
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_scripts' ) );

		add_action( 'pre_get_posts', array( $this, 'callback_pre_get_posts' ) );
		add_action( 'wp_ajax_eo_search', array( $this, 'callback_search' ) );

	}

	/**
	 * Charges le CSS et le JS de WPEO_Search
	 *
	 * @since 1.1.0
	 */
	public function callback_admin_scripts() {
		wp_enqueue_script( 'wpeo_search_script', \eoxia\Config_Util::$init['eo-framework']->wpeo_search->url . '/assets/js/wpeo-search.js', array( 'jquery' ), \eoxia\Config_Util::$init['eo-framework']->wpeo_search->version );
	}

	public function callback_pre_get_posts( $q ) {
		$title = $q->get( '_meta_or_title' );

		if ( $title ) {
			add_filter( 'get_meta_sql', function( $sql ) use ( $title ) {
				global $wpdb;

				static $nr = 0;

				if ( 0 != $nr++ ) {
					return $sql;
				}

				$sql['where'] = sprintf(
					'AND ( %s OR %s ) ',
					$wpdb->prepare( "{$wpdb->posts} . post_title LIKE '%%%s%%'", $title ),
					mb_substr( $sql['where'], 5, mb_strlen( $sql['where'] ) )
				);

				return $sql;
			} );
		}
	}

	/**
	 * Handle search action.
	 *
	 * @since 1.1.0
	 */
	public function callback_search() {
		$term        = ! empty( $_POST['term'] ) ? sanitize_text_field( wp_unslash( $_POST['term'] ) ) : '';
		$slug        = ! empty( $_POST['slug'] ) ? sanitize_text_field( wp_unslash( $_POST['slug'] ) ) : '';
		$type        = ! empty( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '';
		$args        = ! empty( $_POST['args'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['args'] ) ), true ) : '';

		$results = Search_Class::g()->search( $term, $type, $args );
		$results = apply_filters( 'eo_search_results_' . $slug, $results );

		if ( ! empty( $args['next_action'] ) ) {
			do_action( $args['next_action'], array( 'term' => $term, 'users' => $results, 'args' => $args ) );
		}

		ob_start();
		if ( 'post' === $type && empty( $args['args']['model_name'] ) ) {
			\eoxia\View_Util::exec( 'eo-framework', 'wpeo_search', 'list-post-simple', array(
				'term'    => $term,
				'results' => $results,
			) );
		} else {
			\eoxia\View_Util::exec( 'eo-framework', 'wpeo_search', 'list-' . $type, array(
				'term'    => $term,
				'results' => $results,
			) );
		}

		wp_send_json_success( array(
			'view' => ob_get_clean(),
		) );
	}
}

new Search_Action();
