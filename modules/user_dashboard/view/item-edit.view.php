<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-list-item <?php echo $user->id === 0 ? 'wp-digi-table-item-new':  ''; ?>">
	<input type="hidden" name="user[<?php echo $user->id; ?>][id]" value="<?php echo $user->id; ?>" />
	<span class="wp-avatar" style="background: #<?php echo $user->avatar_color; ?>;" ><?php echo $user->initial; ?></span>
	<span><strong>U<?php echo $user->id; ?></strong></span>
	<span class="padded"><input type="text" class="lastname" placeholder="Name" name="user[<?php echo $user->id; ?>][lastname]" value="<?php echo $user->lastname; ?>" /></span>
	<span class="padded"><input type="text" class="firstname" placeholder="Firstname" name="user[<?php echo $user->id; ?>][firstname]" value="<?php echo $user->firstname; ?>" /></span>
	<span class="padded"><input type="text" class="email" placeholder="demo@<?php echo get_option( 'digirisk_domain_mail', 'demo.com' ); ?>" name="user[<?php echo $user->id; ?>][email]" value="<?php echo $user->email; ?>" /></span>
	<span class="add-staff wp-digi-action wp-digi-action-new" >
		<?php
		if ( empty( $user->id ) ):
			?>
			<a href="#" class="wp-digi-action dashicons dashicons-plus" ></a>
			<?php
		else:
			?>
			<a href="#" data-id="<?php echo $user->id; ?>" class="wp-digi-action wp-digi-action-edit fa fa-floppy-o" aria-hidden="true" ></a>
			<?php
		endif;
		?>
	</span>
</li>
