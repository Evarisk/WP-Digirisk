<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="wp-digi-bloc-loader form-chemical-product">
	<?php wp_nonce_field( 'edit_chemical_product' ); ?>
	<input type="hidden" name="action" value="edit_chemical_product" />
	<input type="hidden" name="parent_id" value="<?php echo $society_id; ?>" />

	<ul class="wp-digi-list wp-digi-chemical-product wp-digi-table">
		<?php chemi_product_class::g()->display_chemical_product_list( $society_id ); ?>
		<?php require( CHEMICAL_PRODUCT_VIEW_DIR . '/item-edit.php' ); ?>
	</ul>
</form>
