<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-chemical-product-list-header wp-digi-table-header">
	<span class="wp-digi-chemical-product-list-column-thumbnail" >&nbsp;</span>
	<span class="wp-digi-chemical-product-list-column-id"><?php _e( 'ID', 'digirisk' ); ?></span>
	<span class="wp-digi-chemical-product-list-column-name"><?php _e( 'nom', 'digirisk' ); ?></span>
	<span class="wp-digi-chemical-product-list-column-description"><?php _e( 'descr.', 'digirisk' ); ?> </span>
	<span class="wp-digi-chemical-product-list-column-serial-number"><?php _e('N. CAS', 'digirisk' ); ?></span>
	<span class="wp-digi-chemical-product-list-column-fabrication-date"><?php _e('Reférence', 'digirisk'); ?></span>

	<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
</li>

<?php $i = 1; ?>
<?php if ( !empty( $chemical_product_list ) ) : ?>
	<?php foreach ( $chemical_product_list as $chemical_product ) : ?>
		<?php require( CHEMICAL_PRODUCT_VIEW_DIR . '/list-item.php' ); ?>
	<?php endforeach; ?>
<?php endif; ?>
