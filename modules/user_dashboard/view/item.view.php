<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-risk-item wp-digi-list-item" data-id="<?php echo $user->id; ?>">
	<span class="wp-avatar" style="background: #<?php echo $user->avatar_color; ?>;" ><?php echo $user->initial; ?></span>
	<span><strong>U<?php echo $user->id; ?></strong></span>
	<span><?php echo stripslashes( $user->lastname ); ?></span>
	<span><?php echo stripslashes( $user->firstname ); ?></span>
	<span><?php echo $user->email; ?></span>
	<span class="wp-digi-action wp-digi-user wp-digi-user-action">
		<a href="#"
			data-id="<?php echo $user->id; ?>"
			data-action="load_user"
			data-nonce="<?php echo wp_create_nonce( 'ajax_load_user_' . $user->id ); ?>"
			class="wp-digi-action wp-digi-action-load dashicons action dashicons-edit"></a>

		<a href="#"
			data-id="<?php echo $user->id; ?>"
			data-nonce="<?php echo wp_create_nonce( 'ajax_delete_user_' . $user->id ); ?>"
			data-action="delete_user"
			class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
	</span>
</li>
