<?php
/**
 * Shortcodes
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.1.0
 * @copyright 2015-2016 Eoxia
 * @package group
 * @subpackage shortcode
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Shortcodes
 */
class Group_Shortcode {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_shortcode( 'digi-configuration', array( $this, 'callback_configuration' ) );
	}

	/**
	 * Affiches le formulaire pour configurer un groupement
	 *
	 * @param array $param Les paramètres du shortcode.
	 *
	 * @return void
	 */
	public function callback_configuration( $param ) {
		$element_id = $param['post_id'];
		$element = society_class::g()->show_by_type( $element_id );

		group_configuration_class::g()->display( $element );
	}
}

new group_shortcode();
