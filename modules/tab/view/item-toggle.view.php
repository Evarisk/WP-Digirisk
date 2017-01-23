<?php
/**
 * Affiches les contenu d'un onglet de type toggle
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

<li class="tab-element toggle option" data-parent="toggle" data-target="content">
	<i class="action fa fa-ellipsis-v toggle"></i>
	<ul class="content">
		<?php foreach ( $element['items'] as $key => $sub_element ) : ?>
			<li class="tab-element <?php echo esc_attr( ! empty( $sub_element['parent_class'] ) ? $sub_element['parent_class'] : '' ); ?>"
					data-action="<?php echo esc_attr( ! empty( $sub_element['action'] ) ? $sub_element['action'] : 'digi-' . esc_attr( $key ) ); ?>"
					data-target="main-content"
					<?php echo esc_attr( ! empty( $sub_element['nonce'] ) ? 'data-nonce=' . wp_create_nonce( $sub_element['nonce'] ) : '' ); ?>
					<?php echo ! empty( $sub_element['title'] ) ? 'data-title="' . $sub_element['title'] . '"' : ''; // WPCS: XSS ok. ?>
					<?php echo ! empty( $sub_element['attributes'] ) ? esc_attr( $sub_element['attributes'] ) : ''; ?>
					data-id="<?php echo esc_attr( $id ); ?>">
				<span <?php echo ! empty( $sub_element['class'] ) ? 'class="' . esc_attr( $sub_element['class'] ) . '"' : ''; ?>
					><?php echo $sub_element['text']; // WPCS: XSS ok. ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
</li>
