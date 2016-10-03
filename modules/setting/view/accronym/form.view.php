<?php namespace digi; ?>


<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
	<input type="hidden" name="action" value="update_accronym" />
	<?php wp_nonce_field( 'update_accronym' ); ?>

	<?php view_util::exec( 'setting', 'accronym/list-item', array( 'list_accronym' => $list_accronym ) ); ?>
	<?php echo submit_button(); ?>
</form>
