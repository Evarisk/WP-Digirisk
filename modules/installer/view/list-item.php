<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-risk-item wp-digi-list-item" data-id="<?php echo $user->id; ?>">
	<span class="wp-avatar" style="background: #<?php echo $user->option['user_info']['avatar_color']; ?>;" ><?php echo $user->option['user_info']['initial']; ?></span>
	<span><strong>U<?php echo $user->id; ?></strong></span>
	<span><?php echo stripslashes( $user->option['user_info']['lastname'] ); ?></span>
	<span><?php echo stripslashes( $user->option['user_info']['firstname'] ); ?></span>
	<span><?php echo $user->email; ?></span>
	<span class="wp-digi-action wp-digi-user wp-digi-user-action">
		<a href="#" data-id="<?php echo $user->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_load_user_' . $user->id ); ?>" class="wp-digi-action wp-digi-action-load dashicons dashicons-edit"></a>
		<a href="#" data-id="<?php echo $user->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_user_' . $user->id ); ?>" class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt"></a>
	</span>
</li>
