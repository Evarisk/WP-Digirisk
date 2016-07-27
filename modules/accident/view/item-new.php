<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wp-digi-risk-item wp-digi-risk-item-new wp-digi-list-item wp-digi-bloc-loader" data-epi-id="new" >
	<form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="form-epi">
		<?php wp_nonce_field( 'save_epi' ); ?>
		<input type="hidden" name="action" value="save_epi" />
		<input type="hidden" name="element_id" value="<?php echo $society_id; ?>" />

		<ul class="wp-digi-table">
			<li>
				<?php echo do_shortcode( '[eo_upload_button]' ); ?>
				<span class="wp-digi-epi-action wp-digi-action wp-digi-action-new" >
					<button class="progress-button" data-style="fill" data-horizontal><i class="dashicons dashicons-plus"></i></button>
				</span>
			</li>
		</ul>
	</form>
</div>
