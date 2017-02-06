<?php
/**
 * Affichage d'un utilisateur ainsi que les actions pour l'éditer ou le supprimer.
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

<tr class="user-row">
	<td><div class="avatar" style="background-color: #<?php echo esc_attr( $user->avatar_color ); ?>;"><span><?php echo esc_html( $user->initial ); ?></span></div></td>
	<td class="padding"><span><strong><?php echo esc_html( User_Class::g()->element_prefix . $user->id ); ?><strong></span></td>
	<td class="padding"><span><?php echo esc_html( stripslashes( $user->lastname ) ); ?></span></td>
	<td class="padding"><span><?php echo esc_html( stripslashes( $user->firstname ) ); ?></span<</td>
	<td class="padding"><span><?php echo esc_html( $user->email ); ?></span></td>
	<td>
		<div class="action grid-layout w2">
			<div
				data-id="<?php echo esc_attr( $user->id ); ?>"
				data-action="load_user"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_user' ) ); ?>"
				data-loader="users"
				class="button w50 light edit action-attribute">
				<i class="icon fa fa-pencil"></i>
			</div>

			<div
				data-id="<?php echo esc_attr( $user->id ); ?>"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_user' ) ); ?>"
				data-loader="users"
				data-action="delete_user"
				class="button w50 light delete action-delete" >
				<i class="icon fa fa-times"></i>
			</div>
		</div>
	</td>
</tr>
