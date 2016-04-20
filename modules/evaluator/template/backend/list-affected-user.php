<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-table wp-digi-list-evaluator wp-digi-bloc-loader">
	<li class="wp-digi-table-header">
		<span></span>
		<span><?php _e('ID', 'wpdigi-i18n'); ?></span>
		<span><?php _e('Lastname', 'wpdigi-i18n'); ?></span>
		<span><?php _e('Firstname', 'wpdigi-i18n'); ?></span>
		<span><?php _e('Assignment date', 'wpdigi-i18n'); ?></span>
		<span><?php _e('Period', 'wpdigi-i18n'); ?></span>
		<span></span>
	</li>

<?php global $wpdigi_evaluator_ctr;
	if ( !empty( $list_affected_evaluator ) ):
		foreach ( $list_affected_evaluator as $sub_list_affected_evaluator ):
			if ( !empty( $sub_list_affected_evaluator ) ):
				foreach ( $sub_list_affected_evaluator as $affected_evaluator ):
					?>
						<li>
							<span class="wp-avatar" style="background: #<?php echo $affected_evaluator[ 'user_info' ]->option['user_info']['avatar_color']; ?>;"><?php echo $affected_evaluator[ 'user_info' ]->option['user_info']['initial']; ?></span>
							<span><?php echo $wpdigi_evaluator_ctr->element_prefix . $affected_evaluator[ 'user_info' ]->id; ?></span>
							<span><?php echo $affected_evaluator[ 'user_info' ]->option['user_info']['lastname']; ?></span>
							<span><?php echo $affected_evaluator[ 'user_info' ]->option['user_info']['firstname']; ?></span>
							<span><?php echo  mysql2date( 'd/m/Y H:i', $affected_evaluator[ 'affectation_info' ][ 'start' ][ 'date' ], true ); ?></span>
							<span><?php echo $wpdigi_evaluator_ctr->get_duration( $affected_evaluator[ 'affectation_info' ] ); ?></span>
							<span class="wp-digi-action"><a href="<?php echo admin_url( 'admin-post.php?action=edit_evaluator_detach&group_id=' . $workunit->parent_id . '&workunit_id=' . $workunit->id . '&user_id=' . $affected_evaluator[ 'user_info' ]->id . '&affectation_data_id=' . $affected_evaluator['affectation_info']['id'] ); ?>" class="wp-digi-action-delete dashicons dashicons-no-alt"></a></span>
						</li>
					<?php
				endforeach;
			endif;
		endforeach;
	endif;
?>
</ul>
