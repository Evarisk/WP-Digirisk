<?php
/**
 * Gestion du shortcode pour la signature.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.5.2
 * @copyright 2015-2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Gestion des signatures
 */
class Signature_Shortcode {
	public function __construct() {
		add_shortcode( 'digi_signature', array( $this, 'display' ) );
	}

	public function display( $atts ) {
		$atts = shortcode_atts( array(
			'id'        => 0,
			'parent_id' => 0,
			'key'       => '',
			'type'      => 'post',
		), $atts );

		$atts['id']        = (int) $atts['id'];
		$atts['parent_id'] = (int) $atts['parent_id'];
		$atts['key']       = sanitize_text_field( $atts['key'] );
		$atts['type']      = sanitize_text_field( $atts['type'] );

		if ( is_multisite() && 'user' === $atts['type'] ) {
			$atts['key'] = $GLOBALS['wpdb']->prefix . $atts['key'];
		}

		if ( ! empty( $atts['parent_id'] ) ) {
			$atts['key'] .= '_' . $atts['parent_id'];
		}

		switch ( $atts['type'] ) {
			case 'post':
				$signature_id = get_post_meta( $atts['id'], $atts['key'], true );
				break;
			case 'user':
				$signature_id = get_user_meta( $atts['id'], $atts['key'], true );
				break;
			default:
				$signature_id = get_post_meta( $atts['id'], $atts['key'], true );
				break;
		}

		\eoxia\View_Util::exec(
			'digirisk',
			'signature',
			'main',
			array(
				'id'           => $atts['id'],
				'key'          => $atts['key'],
				'type'         => $atts['type'],
				'signature_id' => $signature_id,
			)
		);
	}
}

new Signature_Shortcode();
