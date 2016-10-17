<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-list-item wp-digi-recommendation-item">
	<?php echo do_shortcode( '[eo_upload_button id="' . $recommendation->id . '" type="recommendation"]' ); ?>
	<span class="wp-digi-recommendation-list-column-reference"><?php echo $recommendation->unique_identifier; ?></span>
	<span><?php echo wp_get_attachment_image( $recommendation->recommendation_category_term[0]->recommendation_term[0]->thumbnail_id, 'thumbnail', false, array( 'title' => $recommendation->recommendation_category_term[0]->recommendation_term[0]->name ) ); ?></span>
	<?php do_shortcode( '[digi_comment id="' . $recommendation->id . '" type="recommendation" display="view"]'); ?>
	<span class="wp-digi-action" >
		<a href="#"
			data-id="<?php echo $recommendation->id; ?>"
			data-nonce="<?php echo wp_create_nonce( 'ajax_load_recommendation_' . $recommendation->id ); ?>"
			data-action="load_recommendation"
			class="wp-digi-action wp-digi-action-load action-attribute dashicons dashicons-edit" ></a>

		<a href="#"
			data-id="<?php echo $recommendation->id; ?>"
			data-nonce="<?php echo wp_create_nonce( 'ajax_delete_recommendation_' . $recommendation->id ); ?>"
			data-action="delete_risk"
			class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
	</span>
</li>
