<?php
/**
 * Affiches les contenu d'un onglet de type toggle
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<li class="tab-element wpeo-dropdown dropdown-right" data-parent="toggle" data-target="content">
	<div class="dropdown-toggle "><i class="icon fas fa-ellipsis-v"></i></div>
	<ul class="dropdown-content">
		<?php foreach ( $element['items'] as $key => $sub_element ) : ?>
			<li class="dropdown-item action-delete"
					data-action="<?php echo esc_attr( ! empty( $sub_element['action'] ) ? $sub_element['action'] : 'digi-' . esc_attr( $key ) ); ?>"
					data-target="main-content"
					<?php echo esc_attr( ! empty( $sub_element['nonce'] ) ? 'data-nonce=' . wp_create_nonce( $sub_element['nonce'] ) : '' ); ?>
					<?php echo ! empty( $sub_element['title'] ) ? 'data-title="' . $sub_element['title'] . '"' : ''; // WPCS: XSS ok. ?>
					<?php echo ! empty( $sub_element['attributes'] ) ? $sub_element['attributes'] : ''; // WPCS: XSS ok. ?>
					data-id="<?php echo esc_attr( $id ); ?>">
				<span <?php echo ! empty( $sub_element['class'] ) ? 'class="' . esc_attr( $sub_element['class'] ) . '"' : ''; ?>
					><?php echo $sub_element['text']; // WPCS: XSS ok. ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
</li>
