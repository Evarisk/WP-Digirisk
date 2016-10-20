<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<span class="wp-digi-recommendation-list-column-term">
	<?php echo wp_get_attachment_image( $recommendation->recommendation_category_term[0]->recommendation_term[0]->thumbnail_id, 'thumbnail', false, array( 'title' => $recommendation->recommendation_category_term[0]->recommendation_term[0]->name ) ); ?>
	<input class="input-hidden-danger" type="hidden" name="taxonomy[digi-recommendation][]" value='<?php echo $recommendation->recommendation_category_term[0]->recommendation_term[0]->id; ?>' />
</span>
