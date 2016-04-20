<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<form class="wp-form-user-to-assign" method="POST" action="<?php echo admin_url( 'admin-post.php' ); ?>">
	<ul class="wp-digi-list wp-digi-table">
		<li class="wp-digi-table-header" >
			<span></span>
			<span><?php _e('ID', 'wpdigi-i18n'); ?></span>
			<span><?php _e('Lastname', 'wpdigi-i18n'); ?></span>
			<span><?php _e('Firtname', 'wpdigi-i18n'); ?></span>
			<span><?php _e('Hiring date', 'wpdigi-i18n'); ?></span>
			<span><?php _e('Assign', 'wpdigi-i18n'); ?></span>
		</li>

		<?php
		if ( !empty( $list_user_to_assign ) ):
			foreach ( $list_user_to_assign as $user_to_assign ):
				?>
				<li class="wp-digi-list-item">
					<span class="wp-avatar" style="background: #<?php echo $user_to_assign->option['user_info']['avatar_color']; ?>;" ><?php echo $user_to_assign->option['user_info']['initial']; ?></span>
					<span><strong>U<?php echo $user_to_assign->id; ?></strong></span>
					<span><?php echo $user_to_assign->option['user_info']['lastname']; ?></span>
					<span><?php echo $user_to_assign->option['user_info']['firstname']; ?></span>
					<span><input type="text" class="wpdigi_date" name="list_user[<?php echo $user_to_assign->id; ?>][on]" value="<?php echo date( 'd/m/Y', strtotime( $user_to_assign->option['user_info']['hiring_date'] ) ); ?>" /></span>
					<span><input type="checkbox" <?php echo in_array( $user_to_assign->id, !empty( $list_affected_id ) ? $list_affected_id : array() ) ? 'disabled="disabled";' : '';?> name="list_user[<?php echo $user_to_assign->id; ?>][affect]" /></span>
				</li>
				<?php
			endforeach;
		endif;
		?>
	</ul>

	<input type="hidden" name="workunit_id" value="<?php echo $workunit->id; ?>" />
	<input type="hidden" name="group_id" value="<?php echo $workunit->parent_id; ?>" />
	<input type="hidden" name="action" value="edit_user_assign" />
	<input type="submit" class="wp-digi-bton-fourth float right" value="<?php _e('Update', 'wpdigi-i18n'); ?>" />

	<?php if ( !empty( $current_page ) && !empty( $number_page ) ): ?>
		<div class="wp-digi-pagination">
			<?php
			$big = 999999999;
			echo paginate_links( array(
				'base' => admin_url( 'admin.php?page=digirisk-simple-risk-evaluation&current_tab=user&current_group_id=' . $workunit->parent_id . '&current_workunit_id=' . $workunit->id . ' &current_page=%_%' ),
				'format' => '%#%',
				'current' => $current_page,
				'total' => $number_page,
				'before_page_number' => '<span class="screen-reader-text">'. __( 'Page', 'wpdigi-i18n' ) .' </span>',
				'type' => 'plain',
				'next_text' => '<i class="dashicons dashicons-arrow-right"></i>',
				'prev_text' => '<i class="dashicons dashicons-arrow-left"></i>'
			) );
			?>
		</div>
	<?php endif; ?>

</form>
