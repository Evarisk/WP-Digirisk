<?php
/**
 * Le tableau des utilisateurs qui peuvent être affecté.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package user
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<form method="POST" class="form-edit-user-assign" action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>">

	<table class="table users">
		<thead>
			<tr>
				<th class="w50"></th>
				<th class="padding"><?php esc_html_e( 'ID', 'digirisk' ); ?></th>
				<th class="padding"><?php esc_html_e( 'Nom', 'digirisk' ); ?></th>
				<th class="padding"><?php esc_html_e( 'Prénom', 'digirisk' ); ?></th>
				<th class="hidden w100 padding"><?php esc_html_e( 'Date d\'embauche', 'digirisk' ); ?></th>
				<th class="w50 padding"><?php esc_html_e( 'Affecter', 'digirisk' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php if ( ! empty( $users ) ) : ?>
				<?php foreach ( $users as $user ) : ?>
					<tr>
						<td class="w50"><div class="avatar" style="background-color: #<?php echo esc_attr( $user->avatar_color ); ?>;"><span><?php echo esc_html( $user->initial ); ?></span></div></td>
						<td class="padding"><span><strong><?php echo esc_html( User_Class::g()->element_prefix . $user->id ); ?><strong></span></td>
						<td class="padding"><span><?php echo esc_html( $user->lastname ); ?></span></td>
						<td class="padding"><span><?php echo esc_html( $user->firstname ); ?></span></td>
						<td class="hidden w100 padding"><input type="text" class="date" name="list_user[<?php echo esc_attr( $user->id ); ?>][on]" value="<?php echo esc_attr( date( 'd/m/Y', strtotime( $user->hiring_date ) ) ); ?>"></td>
						<td class="w50 padding"><input <?php echo esc_attr( in_array( $user->id, ! empty( $list_affected_id ) ? $list_affected_id : array(), true ) ? 'disabled="disabled";' : '' ); ?> type="checkbox" name="list_user[<?php echo esc_attr( $user->id ); ?>][affect]"></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>

	<?php wp_nonce_field( 'edit_user_assign' ); ?>
	<input type="hidden" name="workunit_id" value="<?php echo esc_attr( $workunit->id ); ?>" />
	<input type="hidden" name="group_id" value="<?php echo esc_attr( $workunit->parent_id ); ?>" />
	<input type="hidden" name="action" value="edit_user_assign" />
	<div class="button green uppercase strong float right margin submit-form"><span><?php esc_html_e( 'Mettre à jour', 'digirisk' ); ?></span></div>

	<!-- Pagination -->
	<?php if ( !empty( $current_page ) && !empty( $number_page ) ): ?>
		<div class="wp-digi-pagination">
			<?php
			$big = 999999999;
			echo paginate_links( array(
				'base' => admin_url( 'admin-ajax.php?action=paginate_user&current_page=%_%&element_id=' . $workunit->id ),
				'format' => '%#%',
				'current' => $current_page,
				'total' => $number_page,
				'before_page_number' => '<span class="screen-reader-text">'. __( 'Page', 'digirisk' ) .' </span>',
				'type' => 'plain',
				'next_text' => '<i class="dashicons dashicons-arrow-right"></i>',
				'prev_text' => '<i class="dashicons dashicons-arrow-left"></i>'
			) );
			?>
		</div>
	<?php endif; ?>
</form>
