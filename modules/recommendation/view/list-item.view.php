<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-list-item wp-digi-recommendation-item">
	<span class="wp-digi-recommendation-list-column-thumbnail"><?php echo wp_get_attachment_image( $recommendation->thumbnail_id, 'thumbnail', false, array( 'title' => $recommendation->title ) ); ?></span>
	<span class="wp-digi-recommendation-list-column-reference"><?php echo $recommendation->unique_identifier; ?></span>
	<span><?php echo wp_get_attachment_image( $recommendation->recommendation_category_term[0]->recommendation_term[0]->thumbnail_id, 'thumbnail', false, array( 'title' => $recommendation->recommendation_category_term[0]->recommendation_term[0]->name ) ); ?></span>
	<span class="wp-digi-comment">Comment</span>
	<span class="wp-digi-action">
		<a href="#" class="wp-digi-action wp-digi-action-load dashicons dashicons-edit" ></a>
		<a href="#" class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
	</span>
</li>
