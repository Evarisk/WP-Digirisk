<?php
/**
 * Le tableau des utilisateurs qui sont affectés.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package user
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<table class="table affected-users">
	<thead>
		<tr>
			<th></th>
			<th class="padding"><?php esc_html_e( 'ID', 'digirisk' ); ?></th>
			<th class="padding"><?php esc_html_e( 'Nom', 'digirisk' ); ?></th>
			<th class="padding"><?php esc_html_e( 'Prénom', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Date d\'affectation', 'digirisk' ); ?></th>
			<th></th>
		</tr>
	</thead>

	<tbody>
		<?php if ( ! empty( $list_affected_user ) ) :
			foreach ( $list_affected_user as $affected_user ) : ?>
				<tr>
					<td><div class="avatar" style="background-color: #<?php echo esc_attr( $affected_user->avatar_color ); ?>;"><span><?php echo esc_html( $affected_user->initial ); ?></span></div></td>
					<td class="padding"><span><strong><?php echo esc_html( Evaluator_Class::g()->element_prefix . $affected_user->id ); ?></strong></span></td>
					<td class="padding"><span><?php echo esc_html( $affected_user->lastname ); ?></span></td>
					<td class="padding"><span><?php echo esc_html( $affected_user->firstname ); ?></span></td>
					<td><?php echo esc_html( mysql2date( 'd/m/Y', $affected_user->date_info['start']['date'] ) ); ?></td>
					<td><a 	data-id="<?php echo esc_attr( $workunit->id ); ?>"
									data-nonce="<?php echo esc_attr( wp_create_nonce( 'detach_user' ) ); ?>"
									data-action="detach_user"
									data-user-id="<?php echo esc_attr( $affected_user->id ); ?>"
									class="action-delete dashicons dashicons-no-alt"></a>
						</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
