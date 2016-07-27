<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wp-digi-risk-item wp-digi-risk-item-new wp-digi-list-item wp-digi-bloc-loader" data-epi-id="new" >
	<form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="form-accident">
		<?php wp_nonce_field( 'save_accident' ); ?>
		<input type="hidden" name="action" value="save_accident" />
		<input type="hidden" name="element_id" value="<?php echo $society_id; ?>" />

		<ul class="wp-digi-table">
			<li>
				<?php echo do_shortcode( '[eo_upload_button]' ); ?>
				<span class="wp-digi-risk-select">Liste des risques</span>
				<span class="wp-digi-risk-date"><input type="text" class="wpdigi_date" name="list_comment[0][comment_date]" value="<?php echo current_time( 'd/m/Y', 0 ); ?>" /></span>
				<?php wp_dropdown_users(); ?>
				<span class="wp-digi-risk-date"><input type="text" value="Description" /></span>
				<span class="wp-digi-risk-date"><input type="text" value="Nb jour" /></span>
				<span class="wp-digi-risk-date"><input type="checkbox" value="" /></span>
				<span class="wp-digi-epi-action wp-digi-action wp-digi-action-new" >
					<button class="progress-button" data-style="fill" data-horizontal><i class="dashicons dashicons-plus"></i></button>
				</span>
			</li>
		</ul>
	</form>
</div>
