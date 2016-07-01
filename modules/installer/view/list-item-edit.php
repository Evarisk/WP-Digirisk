<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<form method="POST" class="wp-digi-list-item" data-id="<?php echo $user->id; ?>" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
	<input type="hidden" name="user_id" value="<?php echo $user->id; ?>" />
	<?php wp_nonce_field( 'ajax_installer_edit_user_' . $user->id ); ?>
	<input type="hidden" name="action" value="wpdigi-installer-edit-user" />
	<span class="wp-avatar" style="background: #<?php echo $user->option['user_info']['avatar_color']; ?>;" ><?php echo $user->option['user_info']['initial']; ?></span>
	<span><strong>U<?php echo $user->id; ?></strong></span>
	<span><input type="text" placeholder="Name" name="user[option][user_info][lastname]" value="<?php echo stripslashes($user->option['user_info']['lastname']); ?>" /></span>
	<span><input type="text" placeholder="Firstname" name="user[option][user_info][firstname]" value="<?php echo stripslashes($user->option['user_info']['firstname']); ?>" /></span>
	<span><input type="text" placeholder="email" name="user[email]" value="<?php echo stripslashes($user->email); ?>" /></span>
	<span class="wp-digi-user wp-digi-user-action">
		<a href="#" data-id="<?php echo $user->id; ?>" class="wp-digi-action wp-digi-action-edit dashicons dashicons-edit"></a>
	</span>
</form>
