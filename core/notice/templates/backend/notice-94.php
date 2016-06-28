<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<?php add_thickbox(); ?>
<?php if ( ( 'digirisk_page_digirisk_correctiv_actions' == $current_screen->id ) && !is_plugin_active( 'wp-projects/wpeo_project.php' ) ) : ?>
	<div class="error" >
		<p>
			<strong><?php _e( 'From version 6.0.0.0 Digirisk will use an external plugin for managing projects (correctiv actions).', 'digirisk' ); ?></strong>
			<a title="<?php _e( 'Task manager by Eoxia', 'digirisk' ); ?>" class="thickbox" href="<?php echo esc_url( admin_url( 'plugin-install.php?tab=plugin-information&plugin=task-manager&TB_iframe=true&width=640&height=500' ) ); ?>" ><?php _e( 'Get and install task manager plugin.', 'digirisk' ); ?></a>
		</p>
	</div>
<?php endif; ?>
