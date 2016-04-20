<script type="text/javascript" >
	var datepicker_translation = {
		monthNames: ["<?php _e('Janvier', 'evarisk'); ?>","<?php _e('F&eacute;vrier', 'evarisk'); ?>","<?php _e('Mars', 'evarisk'); ?>","<?php _e('Avril', 'evarisk'); ?>","<?php _e('Mai', 'evarisk'); ?>","<?php _e('Juin', 'evarisk'); ?>", "<?php _e('Juillet', 'evarisk'); ?>","<?php _e('Ao&ucirc;t', 'evarisk'); ?>","<?php _e('Septembre', 'evarisk'); ?>","<?php _e('Octobre', 'evarisk'); ?>","<?php _e('Novembre', 'evarisk'); ?>","<?php _e('D&eacute;cembre', 'evarisk'); ?>"],
		monthNamesShort: ["Jan", "Fev", "Mar", "Avr", "Mai", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		dayNames: ["<?php _e('Dimanche', 'evarisk'); ?>", "<?php _e('Lundi', 'evarisk'); ?>", "<?php _e('Mardi', 'evarisk'); ?>", "<?php _e('Mercredi', 'evarisk'); ?>", "<?php _e('Jeudi', 'evarisk'); ?>", "<?php _e('Vendredi', 'evarisk'); ?>", "<?php _e('Samedi', 'evarisk'); ?>"],
		dayNamesShort: ["<?php _e('Dim', 'evarisk'); ?>", "<?php _e('Lun', 'evarisk'); ?>", "<?php _e('Mar', 'evarisk'); ?>", "<?php _e('Mer', 'evarisk'); ?>", "<?php _e('Jeu', 'evarisk'); ?>", "<?php _e('Ven', 'evarisk'); ?>", "<?php _e('Sam', 'evarisk'); ?>"],
		dayNamesMin: ["<?php _e('Di', 'evarisk'); ?>", "<?php _e('Lu', 'evarisk'); ?>", "<?php _e('Ma', 'evarisk'); ?>", "<?php _e('Me', 'evarisk'); ?>", "<?php _e('Je', 'evarisk'); ?>", "<?php _e('Ve', 'evarisk'); ?>", "<?php _e('Sa', 'evarisk'); ?>"],
	};
	var timepicker_translation = {
		timeText: "<?php _e('Heure', 'evarisk'); ?>",
		hourText: "<?php _e('Heures', 'evarisk'); ?>",
		minuteText: "<?php _e('Minutes', 'evarisk'); ?>",
		amPmText: ["AM", "PM"],
		currentText: "<?php _e('Maintenant', 'evarisk'); ?>",
		closeText: "<?php _e('OK', 'evarisk'); ?>",
		timeOnlyTitle: "<?php _e('Choisissez l\'heure', 'evarisk'); ?>",
		closeButtonText: "<?php _e('Fermer', 'evarisk'); ?>",
		nowButtonText: "<?php _e('Maintenant', 'evarisk'); ?>",
		deselectButtonText: "<?php _e('D&eacute;s&eacute;lectionner', 'evarisk'); ?>",
	};

	var digi_current_date = "<?php echo mysql2date( 'Y-m-d', current_time( 'mysql', 0 ), false ); ?>";
	var digi_current_datetime = "<?php echo mysql2date( 'Y-m-d H:i', current_time( 'mysql', 0 ), false ); ?>";
	var digi_confirm_delete = "<?php echo _e( 'Confirm delete ?', 'wpdigi-i18n' ); ?>"
</script>
