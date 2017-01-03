<script type="text/javascript" >
	var digi_current_date = "<?php echo mysql2date( 'Y-m-d', current_time( 'mysql', 0 ), false ); ?>";
	var digi_current_datetime = "<?php echo mysql2date( 'Y-m-d H:i', current_time( 'mysql', 0 ), false ); ?>";
	var digi_confirm_delete = "<?php _e( 'Voulez vous supprimer cet élément ?', 'digirisk' ); ?>";

	var digi_tools_in_progress = "<?php _e( 'En cours...', 'digirisk'); ?>";
	var digi_tools_done = "<?php _e( 'Terminé', 'digirisk'); ?>";
	var digi_tools_confirm = "<?php _e( 'Attention, avant cette opération, il vous est recommandé de faire une sauvegarde de votre base de donnée.', 'digirisk' ); ?>"

	var digi_loader = "<img src='<?php echo esc_attr( admin_url( '/images/loading.gif' ) ); ?>' alt='<?php echo esc_attr( 'Chargement...' ); ?>' />";
</script>
