<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-table wp-digi-list-staff wp-digi-bloc-loader">
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
			require( USERS_VIEW . 'page-user/item.view.php' );
		endforeach;
	endif;

	require( USERS_VIEW . 'page-user/item-edit.view.php' );
	?>
</ul>
