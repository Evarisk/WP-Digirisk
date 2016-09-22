<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-list-item wp-digi-epi-item" data-epi-id="<?php echo $epi->id; ?>" >
	<?php echo do_shortcode( '[eo_upload_button id="' . $epi->id . '" type="epi"]' ); ?>
	<span class="padded"><?php echo $epi->unique_identifier; ?></span>
	<span class="padded"><?php echo $epi->title; ?></span>
	<span class="padded"><?php echo $epi->content; ?></span>
	<span class="padded"><?php echo $epi->serial_number; ?></span>
	<span class="padded"><?php echo $epi->production_date; ?></span>
	<span class="padded"><?php echo $epi->lifetime; ?></span>
	<span class="padded"><?php echo $epi->review; ?></span>
	<span class="wp-digi-action wp-digi-epi-action" >
		<span class="padded"><a href="#" data-id="<?php echo $epi->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_load_epi_' . $epi->id ); ?>" class="wp-digi-action wp-digi-action-load dashicons dashicons-edit" ></a></span>
		<span class="padded"><a href="#" data-id="<?php echo $epi->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_epi_' . $epi->id ); ?>" class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a></span>
	</span>
</li>
