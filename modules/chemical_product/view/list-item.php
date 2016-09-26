<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-list-item wp-digi-chemical-product-item" data-chemical-product-id="<?php echo $chemical_product->id; ?>" >
	<?php echo do_shortcode( '[eo_upload_button id="' . $chemical_product->id . '" type="chemical_product"]' ); ?>
	<span class="padded"><?php echo $chemical_product->unique_identifier; ?></span>
	<span class="padded"><?php echo $chemical_product->title; ?></span>
	<span class="padded"><?php echo $chemical_product->content; ?></span>
	<span class="padded"><?php echo $chemical_product->CAS_number; ?></span>
	<span class="padded"><?php echo $chemical_product->reference; ?></span>
	<span class="wp-digi-action wp-digi-chemical-product-action" >
		<span class="padded"><a href="#" data-id="<?php echo $chemical_product->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_load_chemical_product_' . $chemical_product->id ); ?>" class="wp-digi-action wp-digi-action-load dashicons dashicons-edit" ></a></span>
		<span class="padded"><a href="#" data-id="<?php echo $chemical_product->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_chemical_product_' . $chemical_product->id ); ?>" class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a></span>
	</span>
</li>
