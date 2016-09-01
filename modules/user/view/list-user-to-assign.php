<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<form class="wp-form-user-to-assign wp-digi-bloc-loader" method="POST" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
	<ul class="wp-digi-list wp-digi-table">
		<li class="wp-digi-table-header" >
			<span></span>
			<span><?php _e('ID', 'digirisk'); ?></span>
			<span><?php _e('Lastname', 'digirisk'); ?></span>
			<span><?php _e('Firtname', 'digirisk'); ?></span>
			<span><?php _e('Hiring date', 'digirisk'); ?></span>
			<span><?php _e('Assign', 'digirisk'); ?></span>
		</li>

		<?php
		if ( !empty( $list_user_to_assign ) ):
			foreach ( $list_user_to_assign as $user_to_assign ):
				?>
				<li class="wp-digi-list-item">
					<span class="wp-avatar" style="background: #<?php echo $user_to_assign->avatar_color; ?>;" ><?php echo $user_to_assign->initial; ?></span>
					<span><strong>U<?php echo $user_to_assign->id; ?></strong></span>
					<span><?php echo $user_to_assign->lastname; ?></span>
					<span><?php echo $user_to_assign->firstname; ?></span>
					<span><input type="text" class="wpdigi_date" name="list_user[<?php echo $user_to_assign->id; ?>][on]" value="<?php echo date( 'd/m/Y', strtotime( $user_to_assign->hiring_date ) ); ?>" /></span>
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
	<input type="submit" class="wp-digi-bton-fourth float right" value="<?php _e('Update', 'digirisk'); ?>" />

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
