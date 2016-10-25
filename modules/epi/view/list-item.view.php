<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-list-item wp-digi-risk-item wp-digi-epi-item" data-epi-id="<?php echo $epi->id; ?>" >
	<?php echo do_shortcode( '[eo_upload_button id="' . $epi->id . '" type="epi"]' ); ?>
	<span class="padded"><?php echo $epi->unique_identifier; ?></span>
	<span class="padded"><?php echo $epi->title; ?></span>
	<span class="padded"><?php echo $epi->serial_number; ?></span>
	<span class="padded"><?php echo $epi->frequency_control; ?></span>
	<span class="padded"><?php echo $epi->control_date; ?></span>
	<span class="padded"><?php echo $epi->compiled_remaining_time; ?></span>

	<span class="wp-digi-action">
		<a href="#"
			data-id="<?php echo $epi->id; ?>"
			data-nonce="<?php echo wp_create_nonce( 'ajax_load_epi_' . $epi->id ); ?>"
			data-action="load_epi"
			class="wp-digi-action wp-digi-action-load action-attribute dashicons dashicons-edit" ></a>

		<a href="#"
			data-id="<?php echo $epi->id; ?>"
			data-nonce="<?php echo wp_create_nonce( 'ajax_delete_epi_' . $epi->id ); ?>"
			data-action="delete_epi"
			class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
	</span>
</li>
