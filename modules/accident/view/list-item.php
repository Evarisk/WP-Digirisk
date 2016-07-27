<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-list-item wp-digi-risk-item" data-risk-id="<?php echo $epi->id; ?>" >
	<?php echo do_shortcode( '[eo_upload_button id="' . $epi->id . '" type="epi"]' ); ?>
	<span class="wp-digi-action wp-digi-risk-action" >
		<a href="#" data-id="<?php echo $epi->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_load_epi_' . $epi->id ); ?>" class="wp-digi-action wp-digi-action-load dashicons dashicons-edit" ></a>
		<a href="#" data-id="<?php echo $epi->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_epi_' . $epi->id ); ?>" class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
	</span>
</li>
