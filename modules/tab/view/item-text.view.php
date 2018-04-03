<?php
/**
 * Affiches les contenu d'un onglet de type texte
 *
 * @author Evarisk <dev@evarisk.com>
 * @since  6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<li class="tab-element <?php echo ( 'digi-' . $key === $tab->slug ) ? 'tab-active' : ''; ?> <?php echo esc_attr( ! empty( $element['parent_class'] ) ? $element['parent_class'] : '' ); ?>"
		data-action="load_tab_content"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_content' ) ); ?>"
		data-target="digi-<?php echo esc_attr( $key ); ?>"
		<?php echo ! empty( $element['title'] ) ? 'data-title="' . $element['title'] . '"' : ''; // WPCS: XSS ok. ?>
		data-id="<?php echo esc_attr( $id ); ?>">
	<span <?php echo ! empty( $element['class'] ) ? 'class="' . esc_attr( $element['class'] ) . '"' : ''; ?>
		><?php echo $element['text']; // WPCS: XSS ok. ?></span>
</li>
