<script type="text/javascript" >
	var digi_current_date = "<?php echo mysql2date( 'Y-m-d', current_time( 'mysql', 0 ), false ); ?>";
	var digi_current_datetime = "<?php echo mysql2date( 'Y-m-d H:i', current_time( 'mysql', 0 ), false ); ?>";
	var digi_confirm_delete = "<?php _e( 'Do you want to delete this item?', 'digirisk' ); ?>";

	var digi_tools_in_progress = "<?php _e( 'In progress...', 'digirisk'); ?>";
	var digi_tools_done = "<?php _e( 'Completed', 'digirisk'); ?>";
	var digi_tools_confirm = "<?php _e( 'Be careful, before doing this, make a backup of your database unless you believe in unicorns.', 'digirisk' ); ?>"

	var digi_loader = "<img src='<?php echo esc_attr( admin_url( '/images/loading.gif' ) ); ?>' alt='<?php echo esc_attr( 'Loading...' ); ?>' />";
</script>
