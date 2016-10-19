<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-list-item <?php echo $user->id === 0 ? 'wp-digi-table-item-new':  ''; ?>">
	<input type="hidden" name="action" value="save_user" />
	<?php wp_nonce_field( 'ajax_save_user' ); ?>
	<input type="hidden" name="id" value="<?php echo $user->id; ?>" />
	<span class="wp-avatar" style="background: #<?php echo $user->avatar_color; ?>;" ><?php echo $user->initial; ?></span>
	<span><strong>U<?php echo $user->id; ?></strong></span>
	<span class="padded"><input type="text" class="lastname" placeholder="Name" name="lastname" value="<?php echo $user->lastname; ?>" /></span>
	<span class="padded"><input type="text" class="firstname" placeholder="Firstname" name="firstname" value="<?php echo $user->firstname; ?>" /></span>
	<span class="padded"><input type="text" class="email" placeholder="demo@<?php echo get_option( 'digirisk_domain_mail', 'demo.com' ); ?>" name="email" value="<?php echo $user->email; ?>" /></span>
	<span class="add-staff wp-digi-action wp-digi-action-new" >
		<?php
		if ( empty( $user->id ) ):
			?>
			<a href="#" class="wp-digi-action dashicons dashicons-plus wp-digi-action-edit"></a>
			<?php
		else:
			?>
			<a href="#" data-id="<?php echo $user->id; ?>" class="wp-digi-action wp-digi-action-edit fa fa-floppy-o" aria-hidden="true" ></a>
			<?php
		endif;
		?>
	</span>
</li>
