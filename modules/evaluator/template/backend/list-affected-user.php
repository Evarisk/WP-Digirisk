<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-table wp-digi-list-evaluator wp-digi-bloc-loader">
	<li class="wp-digi-table-header">
		<span></span>
		<span><?php _e('ID', 'digirisk'); ?></span>
		<span><?php _e('Lastname', 'digirisk'); ?></span>
		<span><?php _e('Firstname', 'digirisk'); ?></span>
		<span><?php _e('Assignment date', 'digirisk'); ?></span>
		<span><?php _e('Period', 'digirisk'); ?></span>
		<span></span>
	</li>

<?php	if ( !empty( $list_affected_evaluator ) ):
		foreach ( $list_affected_evaluator as $sub_list_affected_evaluator ):
			if ( !empty( $sub_list_affected_evaluator ) ):
				foreach ( $sub_list_affected_evaluator as $affected_evaluator ):
					?>
						<li>
							<span class="wp-avatar" style="background: #<?php echo $affected_evaluator[ 'user_info' ]->avatar_color; ?>;"><?php echo $affected_evaluator[ 'user_info' ]->initial; ?></span>
							<span><?php echo evaluator_class::g()->element_prefix . $affected_evaluator[ 'user_info' ]->id; ?></span>
							<span><?php echo $affected_evaluator[ 'user_info' ]->lastname; ?></span>
							<span><?php echo $affected_evaluator[ 'user_info' ]->firstname; ?></span>
							<span><?php echo  mysql2date( 'd/m/Y H:i', $affected_evaluator[ 'affectation_info' ][ 'start' ][ 'date' ], true ); ?></span>
							<span><?php echo evaluator_class::g()->get_duration( $affected_evaluator[ 'affectation_info' ] ); ?></span>
							<span class="wp-digi-action">
								<a 	data-id="<?php echo $element->id; ?>"
										data-user-id="<?php echo $affected_evaluator['user_info']->id; ?>"
										data-affectation-data-id="<?php echo $affected_evaluator['affectation_info']['id']; ?>"
										class="wp-digi-action-delete dashicons dashicons-no-alt"></a>
							</span>
						</li>
					<?php
				endforeach;
			endif;
		endforeach;
	endif;
?>
</ul>
