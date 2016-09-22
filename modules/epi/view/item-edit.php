<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<li class="wp-digi-list-item">
		<?php wp_nonce_field( 'save_epi' ); ?>
		<input type="hidden" name="action" value="save_epi" />
		<input type="hidden" name="parent_id" value="<?php echo $society_id; ?>" />

		<?php echo do_shortcode( '[eo_upload_button]' ); ?>
		<span class="padded"><?php echo $epi->unique_identifier; ?></span>
		<span class="padded"><input type="text" name="title" value="<?php echo $epi->title; ?>" placeholder="Nom" /></span>
		<span class="padded"><input type="text" name="content" value="<?php echo $epi->content; ?>" placeholder="Description" /></span>
		<span class="padded"><input type="text" name="serial_number" value="<?php echo $epi->serial_number; ?>" placeholder="Numéro de série" /></span>
		<span class="padded"><input type="text" class="wpdigi_date" name="production_date" value="<?php echo $epi->production_date; ?>" placeholder="Date de production" /></span>
		<span class="padded"><input type="text" name="lifetime" value="<?php echo $epi->lifetime; ?>" placeholder="Durée de vie" /></span>
		<span class="padded"><input type="text" name="rewiew" value="<?php echo $epi->review; ?>" placeholder="Période de contrôle" /></span>
		<span class="wp-digi-epi-action wp-digi-action-new wp-digi-action" >
			<?php
			if ( empty( $epi->id ) ):
				?>
				<a href="#" class="wp-digi-action dashicons dashicons-plus" ></a>
				<?php
			else:
				?>
				<a href="#" data-id="<?php echo $epi->id; ?>" class="wp-digi-action wp-digi-action-edit fa fa-floppy-o" aria-hidden="true" ></a>
				<?php
			endif;
			?>
		</span>
</li>
