<?php
/**
 * Affichage de la liste des utilisateurs pour affecter les capacités
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="user-row">
	<td><div class="avatar" style="background-color: #<?php echo esc_attr( $user->avatar_color ); ?>;"><span><?php echo esc_html( $user->initial ); ?></span></div></td>
	<td class="padding"><span><strong><?php echo esc_html( \eoxia001\User_Class::g()->element_prefix . $user->id ); ?><strong></span></td>
	<td class="padding"><span><?php echo esc_html( $user->email ); ?></span></td>
	<td class="padding"><span><?php echo esc_html( implode( ', ', $user->wordpress_user->roles ) ); ?></span></td>
	<td>
		<input <?php echo ( $has_capacity_in_role ) ? 'disabled' : ''; ?> <?php echo ( $user->wordpress_user->has_cap( 'manage_digirisk' ) ) ? 'checked' : ''; ?> name="users[<?php echo esc_attr( $user->id ); ?>][capability]" id="have_capability_<?php echo esc_attr( $user->id ); ?>" type="checkbox" /><label for="have_capability_<?php echo esc_attr( $user->id ); ?>"><?php esc_html_e( 'Droit à DigiRisk', 'digirisk' ); ?></label>
	</td>
</tr>
