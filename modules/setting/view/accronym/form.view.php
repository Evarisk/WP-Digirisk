<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
	<input type="hidden" name="action" value="update_accronym" />
	<?php wp_nonce_field( 'update_accronym' ); ?>

	<?php require( SETTING_VIEW_DIR . '/accronym/list-item.view.php' ); ?>
	<?php echo submit_button(); ?>
</form>
