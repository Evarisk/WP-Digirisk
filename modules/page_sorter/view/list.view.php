<?php
/**
 * Affiches la liste des groupements
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$i++;

if ( ! empty( $groupments ) ) :
	foreach ( $groupments as $groupment ) :
		?>
		<li id="menu-item-<?php echo esc_attr( $groupment->id ); ?>" class="menu-item menu-item-depth-<?php echo esc_attr( $i - 1 ); ?> menu-item-custom">
			<div class="menu-item-bar">
				<div class="menu-item-handle ui-sortable-handle">
					<span class="item-title"><?php echo esc_html( $groupment->unique_identifier . ' - ' . $groupment->title ); ?></span>
				</div>
			</div>

			<ul class="menu-item-transport"></ul>
		</li>

		<?php
		if ( ! empty( $groupment->list_group ) ) :
			view_util::exec( 'page_sorter', 'list', array( 'i' => $i, 'groupments' => $groupment->list_group ) );
		endif;
	endforeach;
endif;
