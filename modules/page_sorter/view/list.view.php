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
		<tr class="branch expanded" data-tt-id="<?php echo esc_attr( $establishment->id ); ?>" data-tt-parent-id="<?php echo esc_attr( $establishment->parent_id ); ?>">
			<td>
				<input type="hidden" class="menu-item-data-parent-id" name="menu_item_parent_id[<?php echo esc_attr( $establishment->id ); ?>]" value="<?php echo esc_attr( $establishment->parent_id ); ?>" />
				<input type="hidden" class="menu-item-data-db-id" name="menu_item_db_id[<?php echo esc_attr( $establishment->id ); ?>]" value="<?php echo esc_attr( $establishment->id ); ?>" />
				<span class="<?php echo esc_attr( $establishment->type ); ?>"><?php echo esc_html( $establishment->unique_identifier . ' - ' . $establishment->title ); ?></span>
			</td>

		</tr>

		<?php
		Page_Sorter_Class::g()->display_list( $i, $establishment->id );
	endforeach;
endif;
