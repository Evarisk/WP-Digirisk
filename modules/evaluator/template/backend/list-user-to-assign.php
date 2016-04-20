<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<form method="POST" class="wp-form-evaluator-to-assign wp-digi-bloc-loader" action="<?php echo admin_url( 'admin-post.php' ); ?>">
	<ul class="wp-digi-list wp-digi-table wp-digi-user-list wp-digi-evaluator-list">
		<li class="wp-digi-table-header">
			<span></span>
			<span><?php _e('ID', 'wpdigi-evaluator-i18n'); ?></span>
			<span><?php _e('Lastname', 'wpdigi-evaluator-i18n'); ?></span>
			<span><?php _e('Firstname', 'wpdigi-evaluator-i18n'); ?></span>
			<span><?php _e('Hiring date', 'wpdigi-evaluator-i18n'); ?></span>
			<span><?php _e('Assign', 'wpdigi-evaluator-i18n'); ?> <input type="text" value="15" /></span>
			<span></span>
		</li>

		<?php
		if ( !empty( $list_evaluator_to_assign ) ):
			foreach ( $list_evaluator_to_assign as $evaluator_to_assign ):
				?>
				<li>
					<span class="wp-avatar" style="background: #<?php echo $evaluator_to_assign->option['user_info']['avatar_color']; ?>;" ><?php echo $evaluator_to_assign->option['user_info']['initial']; ?></span>
					<span>U<?php echo $evaluator_to_assign->id; ?></span>
					<span><?php echo $evaluator_to_assign->option['user_info']['lastname']; ?></span>
					<span><?php echo $evaluator_to_assign->option['user_info']['firstname']; ?></span>
					<span><input type="text" class="wpdigi_date" name="list_user[<?php echo $evaluator_to_assign->id; ?>][on]" value="<?php echo date( 'd/m/Y', strtotime( $evaluator_to_assign->option['user_info']['hiring_date'] ) ); ?>" /></span>
					<span class="period-assign"><input type="text" name="list_user[<?php echo $evaluator_to_assign->id; ?>][duration]" value="" /></span>
					<span><input type="checkbox" name="list_user[<?php echo $evaluator_to_assign->id; ?>][affect]" /></span>
				</li>
				<?php
			endforeach;
		endif;
		?>
	</ul>


	<input type="hidden" name="workunit_id" value="<?php echo $workunit->id; ?>" />
	<input type="hidden" name="group_id" value="<?php echo $workunit->parent_id; ?>" />
	<input type="hidden" name="action" value="edit_evaluator_assign" />
	<input type="submit" class="wp-digi-bton-fourth float right" value="<?php _e('Update', 'wpdigi-user-i18n'); ?>" />

	<!-- Pagination -->
	<?php if ( !empty( $current_page ) && !empty( $number_page ) ): ?>
		<div class="wp-digi-pagination">
			<?php
			$big = 999999999;
			echo paginate_links( array(
				'base' => admin_url( 'admin.php?page=digirisk-simple-risk-evaluation&current_tab=evaluator&current_group_id=' . $workunit->parent_id . '&current_workunit_id=' . $workunit->id .'&current_page=%_%' ),
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
