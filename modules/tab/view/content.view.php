<?php
/**
 * Affiches le contenu principale
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div><?php echo ! empty( $tab->tab_before_slug ) ? $tab->tab_before_slug : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>

<div class="wpeo-grid">
	<h1><?php echo esc_html( $tab->title ); ?></h1>
	<div><?php echo ! empty( $tab->tab_next_slug ) ? $tab->tab_next_slug : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>

</div>

<div><?php echo ! empty( $tab->tab_after_slug ) ? $tab->tab_after_slug : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>

<?php echo do_shortcode( '[' . $tab->slug . ' post_id="' . $id . '" ]' ); ?>
