<?php
/**
 * Class define shortcode for search module.
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright (c) 2015-2018 Eoxia <dev@eoxia.com>.
 *
 * @license GPLv3 <https://spdx.org/licenses/GPL-3.0-or-later.html>
 *
 * @package EO_Framework\EO_Search\Shortcode
 *
 * @since 1.1.0
 */

namespace eoxia;

defined( 'ABSPATH' ) || exit;

/**
 * Search Shortcode Class.
 */
class Search_Shortcode {

	/**
	 * Constructor.
	 *
	 * @since 1.1.0
	 */
	public function __construct() {
		add_shortcode( 'wpeo_search', array( $this, 'callback_wpeo_search' ) );
	}

	/**
	 * Handle search shortcode.
	 *
	 * @param array $atts Attributes used by the shortcode.
	 *
	 * @since 1.1.0
	 */
	public function callback_wpeo_search( $atts ) {
		$atts = shortcode_atts( array(
			'label' => '',
			'slug'  => '',
			'name'  => 'id',
			'id'    => '',
			'type'  => 'post',
			'icon'  => '',
			'value' => '',
			'args'  => array(),
		), $atts, 'wpeo_search' );

		Search_Class::g()->display( $atts );
	}
}

new Search_Shortcode();
