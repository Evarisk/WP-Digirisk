<?php
/**
 * La liste des utilisateurs
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package user_dashboard
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

	<thead>
		<tr>
			<td class="w50"></td>
			<td class="w50 padding"><?php esc_html_e( 'ID', 'digirisk' ); ?></td>
			<td class="padding"><?php esc_html_e( 'Lastname', 'digirisk' ); ?></td>
			<td class="padding"><?php esc_html_e( 'Firtname', 'digirisk' ); ?></td>
			<td class="padding"><?php esc_html_e( 'Email', 'digirisk' ); ?></td>
			<td class="w100"></td>
		</tr>
	</thead>

	<tbody>
		<?php
		if ( ! empty( $list_user ) ) :
			foreach ( $list_user as $user ) :
				View_Util::exec( 'user_dashboard', 'item', array( 'user' => $user ) );
			endforeach;
		endif;

		// Formulaire d'édition pour une nouvelle entrée.
		View_Util::exec( 'user_dashboard', 'item-edit', array( 'user' => $user_schema ) );
		?>
	</tbody>
