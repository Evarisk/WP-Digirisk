<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-table wp-digi-list-affected-user wp-digi-bloc-loader" >
	<li class="wp-digi-table-header" >
		<span></span>
		<span><?php _e('ID', 'digirisk'); ?></span>
		<span><?php _e('Lastname', 'digirisk'); ?></span>
		<span><?php _e('Firstname', 'digirisk'); ?></span>
		<span><?php _e('Assignment date', 'digirisk'); ?></span>
		<span></span>
	</li>
	<?php
	if ( !empty( $list_affected_user ) ):
		foreach ( $list_affected_user as $affected_user ):
			?>
			<li class="wp-digi-list-item">
				<span class="wp-avatar" style="background: #<?php echo $affected_user->avatar_color; ?>;"><?php echo $affected_user->initial; ?></span>
				<span><strong>U<?php echo $affected_user->id; ?></strong></span>
				<span><?php echo $affected_user->lastname; ?></span>
				<span><?php echo $affected_user->firstname; ?></span>
				<span><?php echo mysql2date( 'd M. Y', $affected_user->date_info['start']['date'] ); ?></span>
				<span class="wp-digi-action">
					<a 	data-id="<?php echo $workunit->id; ?>"
							data-user-id="<?php echo $affected_user->id; ?>"
							class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt"></a></span>
			</li>
			<?php
		endforeach;
	endif;
	?>
</ul>
