<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<form method="POST" class="wp-digi-list-item" data-id="<?php echo $user[0]->id; ?>" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
	<input type="hidden" name="user[id]" value="<?php echo $user[0]->id; ?>" />
	<?php wp_nonce_field( 'ajax_save_user' ); ?>
	<input type="hidden" name="action" value="save_user" />
	<span class="wp-avatar" style="background: #<?php echo $user[0]->avatar_color; ?>;" ><?php echo $user[0]->initial; ?></span>
	<span><strong>U<?php echo $user[0]->id; ?></strong></span>
	<span><input type="text" placeholder="Name" name="user[lastname]" value="<?php echo stripslashes($user[0]->lastname); ?>" /></span>
	<span><input type="text" placeholder="Firstname" name="user[firstname]" value="<?php echo stripslashes($user[0]->firstname); ?>" /></span>
	<span><input type="text" placeholder="email" name="user[email]" value="<?php echo stripslashes($user[0]->email); ?>" /></span>
	<span class="wp-digi-action wp-digi-user wp-digi-user-action">
		<a href="#" data-id="<?php echo $user[0]->id; ?>" class="wp-digi-action wp-digi-action-edit fa fa-floppy-o" aria-hidden="true"></a>
	</span>
</form>
