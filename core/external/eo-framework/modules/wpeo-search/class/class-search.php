<?php
/**
 * Main class for search module.
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright (c) 2015-2018 Eoxia <dev@eoxia.com>.
 *
 * @license GPLv3 <https://spdx.org/licenses/GPL-3.0-or-later.html>
 *
 * @package EO_Framework\EO_Search\Class
 *
 * @since 1.1.0
 */

namespace eoxia;

defined( 'ABSPATH' ) || exit;

/**
 * Search Class.
 */
class Search_Class extends Singleton_Util {

	/**
	 * List of registered search.
	 *
	 * @since 1.1.0
	 *
	 * @var array
	 */
	private $registered_search = array();

	/**
	 * Constructor.
	 *
	 * @since 1.1.0
	 */
	protected function construct() {}

	public function register_search( $slug, $atts ) {
		$this->registered_search[ $slug ] = $this->construct_atts( $slug, $atts );
	}

	public function get_registered_search( $slug ) {
		return $this->registered_search[ $slug ];
	}

	private function construct_atts( $slug, $atts ) {
		$default = array(
			'value'        => '',
			'hidden_value' => '',
		);

		$atts['slug'] = $slug;
		$atts['id']   = '';

		if ( ! empty( $atts['label'] ) ) {
			$atts['id'] = sanitize_title( $atts['label'] );
		}

		$atts = wp_parse_args( $atts, $default );

		return $atts;
	}

	/**
	 * This method get a registered search in the $registed_search array
	 * by the $slug.
	 *
	 * This method call the "main" view of search module.
	 *
	 * @since 1.1.0
	 *
	 * @param  array $atts [description]
	 */
	public function display( $slug, $visible_value = '', $hidden_value = '' ) {
		$atts = $this->get_registered_search( $slug );

		\eoxia\View_Util::exec( 'eo-framework', 'wpeo_search', 'main', array(
			'atts' => $atts,
		) );
	}

	/**
	 * This method switch by type for call another method.
	 *
	 * @since 1.1.0
	 *
	 * @param  string $term Term of search.
	 * @param  string $type Type of search.
	 * @param  array  $args Other parameters.
	 *
	 * @return array        Array of results.
	 */
	public function search( $term, $type, $args ) {
		switch ( $type ) {
			case "user":
				$results = $this->search_user( $term, $args );
				break;
			case "post":
				$results = $this->search_post( $term, $args );
				break;
			default:
				break;
		}

		return $results;
	}

	private function search_user( $term, $data ) {
		if ( ! empty( $term ) ) {
			$args = array(
				'search' => '*' . $term . '*',
			);

			if ( ! empty( $data['args'] ) ) {
				$args = array_merge( $args, $data['args'] );
			}

			$results = User_Class::g()->get( $args );
		} else {
			$results = User_Class::g()->get( array(
				'exclude' => array( 1 ),
			) );
		}

		return $results;
	}

	private function search_post( $term, $data ) {
		$results = array();

		// $get_args = array( 'meta_or_title' => $term );

		$get_args = array( 's' => $term );

		if ( ! empty( $data['args']['meta_query'] ) ) {
			$get_args['meta_query'] = $this->construct_meta_query( $term, $data['args']['meta_query'] );
		}

		$get_args = array_merge( $get_args, $data['args'] );

		if ( ! empty( $data['args']['model_name'] ) ) {
			foreach ( $data['args']['model_name'] as $model_name ) {
				$results = array_merge( $results, $model_name::g()->get( $get_args ) );
			}
		} else {
			$get_args['posts_per_page'] = -1;
			$results = get_posts( $get_args );
		}

		return $results;
	}

	private function construct_meta_query( $term, $args_meta_query ) {
		if ( ! empty( $args_meta_query ) ) {
			foreach ( $args_meta_query as &$meta_data ) {
				if ( ! empty( $meta_data ) && is_array( $meta_data ) ) {
					$meta_data['value'] = $term;
				}
			}
		}

		return $args_meta_query;
	}
}

global $eo_search;
$eo_search = Search_Class::g();
