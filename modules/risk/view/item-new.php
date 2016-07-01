<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wp-digi-risk-item wp-digi-risk-item-new wp-digi-list-item <?php $i++; echo ( $i%2 ? 'odd' : 'even' ); ?> wp-digi-bloc-loader" data-risk-id="new" >
	<form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="form-risk">
		<?php wp_nonce_field( 'save_risk' ); ?>
		<input type="hidden" name="action" value="save_risk" />
		<input type="hidden" name="global" value="<?php echo str_replace( 'mdl_01', 'ctr', get_class( $element ) ); ?>" />
		<input type="hidden" name="element_id" value="<?php echo $element->id; ?>" />

		<ul class="wp-digi-table">
			<li>
				<?php echo do_shortcode( '[eo_upload_button]' ); ?>
				<?php do_shortcode( '[digi_evaluation_method]' ); ?>

				<span class="wp-digi-risk-list-column-reference"></span>

				<span class="wp-digi-risk-select"><?php danger_category_class::get()->display_category_danger( array( 'with_danger' => true, ) ); ?></span>

				<span class="wp-digi-risk-date"><input type="text" class="wpdigi_date" name="comment_date[]" value="<?php echo current_time( 'd/m/Y', 0 ); ?>" /></span>
				<span class="wp-digi-risk-comment" ><textarea name="comment_content[]" rows="1" placeholder="<?php _e( 'Add a comment for the risk', 'digirisk' ); ?>" ></textarea></span>

				<span class="wp-digi-risk-action wp-digi-action wp-digi-action-new" >
					<button class="progress-button" data-style="fill" data-horizontal><i class="dashicons dashicons-plus"></i></button>
				</span>
			</li>
		</ul>

		<?php do_shortcode( '[digi_evaluation_method_complex]' ); ?>
	</form>
</div>
