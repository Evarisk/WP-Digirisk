<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-table wp-digi-list-affected-user wp-digi-bloc-loader" >
	<li class="wp-digi-table-header" >
		<span></span>
		<span><?php _e('ID', 'wpdigi-i18n'); ?></span>
		<span><?php _e('Lastname', 'wpdigi-i18n'); ?></span>
		<span><?php _e('Firstname', 'wpdigi-i18n'); ?></span>
		<span><?php _e('Assignment date', 'wpdigi-i18n'); ?></span>
		<span></span>
	</li>
	<?php
	global $wpdigi_user_ctr;
	if ( !empty( $list_affected_user ) ):
		foreach ( $list_affected_user as $affected_user ):
			if ( $wpdigi_user_ctr->get_user_is_assigned_in_workunit_by_user_id( $workunit, $affected_user->id ) === true ):
				?>
				<li class="wp-digi-list-item">
					<span class="wp-avatar" style="background: #<?php echo $affected_user->option['user_info']['avatar_color']; ?>;"><?php echo $affected_user->option['user_info']['initial']; ?></span>
					<span><strong>U<?php echo $affected_user->id; ?></strong></span>
					<span><?php echo $affected_user->option['user_info']['lastname']; ?></span>
					<span><?php echo $affected_user->option['user_info']['firstname']; ?></span>
					<span><?php echo mysql2date( 'd M. Y', $affected_user->option['date_info']['start']['date'] ); ?></span>
					<span class="wp-digi-action">
						<a 	data-workunit-id="<?php echo $workunit->id; ?>"
								data-user-id="<?php echo $affected_user->id; ?>"
								class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt"></a></span>
				</li>
				<?php
			endif;
		endforeach;
	endif;
	?>
</ul>
