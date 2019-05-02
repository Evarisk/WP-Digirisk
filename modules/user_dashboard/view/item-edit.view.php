<?php
/**
 * Affichage d'un utilisateur en mode édition.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.9
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="user-row edit">
	<input type="hidden" name="action" value="save_user" />
	<?php wp_nonce_field( 'ajax_save_user' ); ?>
	<input type="hidden" name="id" value="<?php echo esc_attr( $user->data['id'] ); ?>" />

	<td>
		<?php if ( 0 !== $user->data['id'] ) : ?>
			<div class="avatar" style="background-color: #<?php echo esc_attr( $user->data['avatar_color'] ); ?>;">
				<span><?php echo esc_html( $user->data['initial'] ); ?></span>
			</div>
		<?php endif; ?>
	</td>
	<td class="padding">
		<?php if ( 0 !== $user->data['id'] ) : ?>
			<span>
				<strong><?php echo esc_html( \eoxia\User_Class::g()->element_prefix . $user->data['id'] ); ?><strong>
			</span>
		<?php endif; ?>
	</td>
	<td class="padding">
		<input type="text" class="lastname" placeholder="<?php esc_attr_e( 'Nom', 'digirisk' ); ?>" name="lastname" value="<?php echo esc_attr( $user->data['lastname'] ); ?>" />
	</td>
	<td class="padding">
		<input type="text" class="firstname" placeholder="<?php esc_attr_e( 'Prénom', 'digirisk' ); ?>" name="firstname" value="<?php echo esc_attr( $user->data['firstname'] ); ?>" />
	</td>
	<td class="padding email">
		<input type="text" class="email" placeholder="demo@<?php echo esc_attr( get_option( 'digirisk_domain_mail', 'demo.com' ) ); ?>" name="email" value="<?php echo esc_attr( $user->data['email'] ); ?>" />
		<p class="email-already-used" style="display: none; line-height: 0; color: red;"><?php esc_html_e( 'Adresse de messagerie déjà utilisée', 'digirisk' ); ?></p>
	</td>
	<td>
		<div class="action">
			<?php if ( empty( $user->data['id'] ) ) : ?>
				<div class="wpeo-button button-square-50 button-disable add action-input"
					data-namespace="digirisk"
					data-module="userDashboard"
					data-before-method="checkData"
					data-parent="user-row"
					data-loader="table">
					<i class="icon fas fa-plus"></i>
				</div>
			<?php	else : ?>
				<div class="wpeo-button button-square-50 button-green add action-input"
					data-namespace="digirisk"
					data-module="userDashboard"
					data-before-method="checkData"
					data-parent="user-row"
					data-loader="table">
					<i class="icon fas fa-save"></i>
				</div>
			<?php	endif; ?>
		</div>
	</td>
</tr>
