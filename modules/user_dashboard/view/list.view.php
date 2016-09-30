<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

	<li class="wp-digi-table-header">
		<span></span>
		<span><?php _e('ID', 'digirisk'); ?></span>
		<span><?php _e('Lastname', 'digirisk'); ?></span>
		<span><?php _e('Firtname', 'digirisk'); ?></span>
		<span><?php _e('Email', 'digirisk'); ?></span>
		<span></span>
	</li>

	<?php
	if ( !empty( $list_user ) ):
	  foreach ( $list_user as $user ):
			view_util::exec( 'user_dashboard', 'item', array( 'user' => $user ) );
	  endforeach;
	endif;
	?>
