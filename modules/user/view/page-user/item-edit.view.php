<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-list-item wp-digi-table-item-new">
	<input type="hidden" name="action" value="save_user" />
	<?php wp_nonce_field( 'ajax_save_user' ); ?>
	<span class="wp-avatar" style="background: #FFF;" ></span>
	<span></span>
	<span class="padded"><input type="text" placeholder="Name" name="user[lastname]" /></span>
	<span class="padded"><input type="text" placeholder="Firstname" name="user[firstname]" /></span>
	<span class="padded"><input type="text" placeholder="demo@<?php echo get_option( 'digirisk_domain_mail', 'demo.com' ); ?>" name="user[email]" /></span>
	<span class="add-staff wp-digi-action wp-digi-action-new" ><a href="#" class="wp-digi-action dashicons dashicons-plus" ></a></span>
</li>
