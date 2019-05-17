<?php
/**
 * Une ligne du tableau des utilisateurs dans la page "digirisk-users".
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.2.3
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<tr class="user-row" data-id="<?php echo esc_attr( $user->data['id'] ); ?>">
	<td><div class="avatar" style="background-color: #<?php echo esc_attr( $user->data['avatar_color'] ); ?>;"><span><?php echo esc_html( $user->data['initial'] ); ?></span></div></td>
	<td class="padding"><span><strong><?php echo esc_html( \eoxia\User_Class::g()->element_prefix . $user->data['id'] ); ?><strong></span></td>
	<td class="padding"><span><?php echo esc_html( stripslashes( $user->data['lastname'] ) ); ?></span></td>
	<td class="padding"><span><?php echo esc_html( stripslashes( $user->data['firstname'] ) ); ?></span<</td>
	<td class="padding"><span><?php echo esc_html( $user->data['email'] ); ?></span></td>
	<td>
		<div class="action wpeo-gridlayout grid-3 grid-gap-0">
			<div
				data-id="<?php echo esc_attr( $user->data['id'] ); ?>"
				data-action="load_user_details"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_user_details' ) ); ?>"
				class="wpeo-button button-square-50 button-transparent wpeo-modal-event">
				<i class="button-icon fas fa-eye"></i>
			</div>

			<div
				data-id="<?php echo esc_attr( $user->data['id'] ); ?>"
				data-action="load_user"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_user' ) ); ?>"
				data-loader="users"
				class="wpeo-button button-square-50 button-transparent edit action-attribute">
				<i class="button-icon fas fa-pencil-alt"></i>
			</div>

			<div
				data-id="<?php echo esc_attr( $user->data['id'] ); ?>"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_user' ) ); ?>"
				data-message-delete="<?php esc_attr_e( 'Confirmer la suppression', 'digirisk' ); ?>"
				data-loader="users"
				data-action="delete_user"
				class="wpeo-button button-square-50 button-transparent delete action-delete" >
				<i class="button-icon fas fa-times"></i>
			</div>
		</div>
	</td>
</tr>
