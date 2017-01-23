<?php
/**
 * Affiches les contenu d'un onglet de type texte
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package tab
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<li class="tab-element <?php echo ( 'digi-' . $key === $display ) ? 'active' : ''; ?> <?php echo esc_attr( ! empty( $element['parent_class'] ) ? $element['parent_class'] : '' ); ?>"
		data-action="digi-<?php echo esc_attr( $key ); ?>"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_content' ) ); ?>"
		data-target="main-content"
		<?php echo ! empty( $element['title'] ) ? 'data-title="' . $element['title'] . '"' : ''; // WPCS: XSS ok. ?>
		data-id="<?php echo esc_attr( $id ); ?>">
	<span <?php echo ! empty( $element['class'] ) ? 'class="' . esc_attr( $element['class'] ) . '"' : ''; ?>
		><?php echo $element['text']; // WPCS: XSS ok. ?></span>
</li>
