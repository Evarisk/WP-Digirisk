<?php
/**
 * Vue contenant la liste des établissements pour gérer l'organiseur.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$i++;

if ( ! empty( $establishments ) ) :
	foreach ( $establishments as $establishment ) :
		?>
		<li id="menu-item-<?php echo esc_attr( $establishment->id ); ?>" data-drop="<?php echo ( ! empty( $establishment->count_workunit ) ||( Workunit_Class::g()->get_post_type() === $establishment->type ) ) ? false : true; ?>" data-depth="<?php echo esc_attr( $i - 1 ); ?>" class="<?php echo ! empty( $establishment->count_workunit ) ? 'no-drop' : ''; ?> menu-item-depth-<?php echo esc_attr( $i - 1 ); ?>">
			<div class="menu-item-bar">
				<div class="menu-item-handle ui-sortable-handle">
					<span class="item-title"><?php echo esc_html( $establishment->unique_identifier . ' - ' . $establishment->title ); ?></span>
				</div>
			</div>

			<input type="hidden" class="menu-item-data-parent-id" name="menu_item_parent_id[<?php echo esc_attr( $establishment->id ); ?>]" value="<?php echo esc_attr( $establishment->parent_id ); ?>" />
			<input type="hidden" class="menu-item-data-db-id" name="menu_item_db_id[<?php echo esc_attr( $establishment->id ); ?>]" value="<?php echo esc_attr( $establishment->id ); ?>" />

			<ul class="menu-item-transport"></ul>
		</li>

		<?php
		Page_Sorter_Class::g()->display_list( $i, $establishment->id );
	endforeach;
endif;
