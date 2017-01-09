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
		<?php
		foreach ( $element['items'] as $key => $sub_element ) :
			?><li
				<?php echo 'class="item ' . ( ! empty( $sub_element['class'] ) ? esc_attr( $sub_element['class'] ) : '' ); ?>"
				<?php echo ! empty( $sub_element['nonce'] ) ? 'data-nonce="' . esc_attr( $sub_element['nonce'] ) . '"' : ''; ?>
				<?php echo ! empty( $sub_element['attributes'] ) ? esc_attr( $sub_element['attributes'] ) : ''; ?>
				><?php echo esc_html( $sub_element['text'] ); ?></li><?php
		endforeach;
		?>
	</ul>
</li>
