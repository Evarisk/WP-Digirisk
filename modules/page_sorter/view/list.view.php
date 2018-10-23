<?php
/**
 * Vue contenant la liste des établissements pour gérer l'organiseur.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

$i++;

if ( ! empty( $establishments ) ) :
	foreach ( $establishments as $establishment ) :
		?>
		<tr class="branch expanded" data-tt-id="<?php echo esc_attr( $establishment->data['id'] ); ?>" data-tt-parent-id="<?php echo esc_attr( $establishment->data['parent_id'] ); ?>">
			<td>
				<input type="hidden" class="menu-item-data-parent-id" name="menu_item_parent_id[<?php echo esc_attr( $establishment->data['id'] ); ?>]" value="<?php echo esc_attr( $establishment->data['parent_id'] ); ?>" />
				<input type="hidden" class="menu-item-data-db-id" name="menu_item_db_id[<?php echo esc_attr( $establishment->data['id'] ); ?>]" value="<?php echo esc_attr( $establishment->data['id'] ); ?>" />
				<span class="<?php echo esc_attr( $establishment->data['type'] ); ?>"><?php echo esc_html( $establishment->data['unique_identifier'] . ' - ' . $establishment->data['title'] ); ?></span>
			</td>

		</tr>

		<?php
		Page_Sorter_Class::g()->display_list( $i, $establishment->data['id'] );
	endforeach;
endif;
