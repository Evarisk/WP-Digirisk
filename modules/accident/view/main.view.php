<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="wp-digi-bloc-loader form-accident">
	<?php wp_nonce_field( 'edit_accident' ); ?>
	<input type="hidden" name="action" value="edit_accident" />
	<input type="hidden" name="parent_id" value="<?php echo $society_id; ?>" />

	<ul class="wp-digi-list wp-digi-accident wp-digi-table">
		<?php accident_class::g()->display_accident_list( $society_id ); ?>
		<?php require( ACCIDENT_VIEW_DIR . '/item-edit.php' ); ?>
	</ul>
</form>
