<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<li class="wp-digi-list-item">
	<span class="wp-avatar" style="background: #<?php echo $user->option['user_info']['avatar_color']; ?>;" ><?php echo $user->option['user_info']['initial']; ?></span>
	<span><strong>U<?php echo $user->id; ?></strong></span>
	<span><?php echo $user->option['user_info']['lastname']; ?></span>
	<span><?php echo $user->option['user_info']['firstname']; ?></span>
	<span><?php echo $user->email; ?></span>
</li>
