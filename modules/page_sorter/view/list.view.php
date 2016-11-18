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
		<li id="menu-item-<?php echo esc_attr( $groupment->id ); ?>" data-drop="<?php echo ! empty( $groupment->list_workunit ) ? false : true; ?>" data-depth="<?php echo esc_attr( $i - 1 ); ?>" class="<?php echo ! empty( $groupment->list_workunit ) ? 'no-drop' : ''; ?> menu-item-depth-<?php echo esc_attr( $i - 1 ); ?>">
			<div class="menu-item-bar">
				<div class="menu-item-handle ui-sortable-handle">
					<span class="item-title"><?php echo esc_html( $groupment->unique_identifier . ' - ' . $groupment->title ); ?></span>
				</div>
			</div>

			<input type="hidden" class="menu-item-data-parent-id" name="menu_item_parent_id[<?php echo esc_attr( $groupment->id ); ?>]" value="<?php echo esc_attr( $groupment->parent_id ); ?>" />
			<input type="hidden" class="menu-item-data-db-id" name="menu_item_db_id[<?php echo esc_attr( $groupment->id ); ?>]" value="<?php echo esc_attr( $groupment->id ); ?>" />

			<ul class="menu-item-transport"></ul>
		</li>

		<?php
		if ( ! empty( $groupment->list_group ) ) :
			view_util::exec( 'page_sorter', 'list', array( 'i' => $i, 'groupments' => $groupment->list_group ) );
		endif;
	endforeach;
endif;
