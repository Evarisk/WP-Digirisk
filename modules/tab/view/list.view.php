<?php
/**
 * Loop the list_tab for display it.
 * Each tab have an attribute data-action for javascript request.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package tab
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<ul class="tab">
	<?php
	if ( ! empty( $list_tab[ $type ] ) ) :
		foreach ( $list_tab[ $type ] as $key => $element ) :
			$class = '';
			if ( 'digi-' . $key === $display ) {
				$class = 'active';
			}
			?><li class="tab-element" data-action="digi-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $element['text'] ); ?></li><?php
		endforeach;
	endif; ?>


	<?php
	if ( ! empty( $list_tab_more ) ) :
		?>
		<li class="tab-element toggle option" data-parent="toggle" data-target="content">
			<i class="action fa fa-ellipsis-v toggle"></i>
			<ul class="content">
				<?php
				foreach ( $list_tab_more as $key => $element ) :
					?><li
						class="item <?php echo esc_attr( $element['class'] ); ?>"
						data-nonce="<?php echo esc_attr( $element['nonce'] ); ?>"
						<?php echo esc_attr( $element['attributes'] ); ?> ><?php echo esc_html( $element['text'] ); ?></li><?php
				endforeach;
				?>
			</ul>
		</li>
	<?php
	endif;
	?>
</ul>
