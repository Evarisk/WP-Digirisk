<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wp-digi-epi-item wp-digi-epi-item-new wp-digi-list-item wp-digi-bloc-loader" data-epi-id="new" >
	<form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="form-epi">
		<?php wp_nonce_field( 'save_epi' ); ?>
		<input type="hidden" name="action" value="save_epi" />
		<input type="hidden" name="parent_id" value="<?php echo $society_id; ?>" />

		<ul class="wp-digi-table">
			<li>
				<?php echo do_shortcode( '[eo_upload_button]' ); ?>
				<span>&nbsp;</span>
				<span class="padded"><input type="text" name="title" value="" placeholder="Nom" /></span>
				<span class="padded"><input type="text" name="content" value="" placeholder="Description" /></span>
				<span class="padded"><input type="text" name="serial_number" value="" placeholder="Numéro de série" /></span>
				<span class="padded"><input type="text" class="wpdigi_date" name="production_date" value="" placeholder="Date de production" /></span>
				<span class="padded"><input type="text" name="lifetime" value="" placeholder="Durée de vie" /></span>
				<span class="padded"><input type="text" name="rewiew" value="" placeholder="Période de contrôle" /></span>
				<span class="wp-digi-epi-action wp-digi-action-new wp-digi-action" ><a href="#" class="wp-digi-action dashicons dashicons-plus" ></a></span>
			</li>
		</ul>
	</form>
</div>
