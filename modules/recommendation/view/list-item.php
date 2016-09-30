<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<li class="wp-digi-list-item wp-digi-recommendation-item">
	<span class="wp-digi-recommendation-list-column-thumbnail"><?php echo wp_get_attachment_image( $term->thumbnail_id, 'thumbnail', false, array( 'title' => $term->name ) ); ?></span>
	<span class="wp-digi-recommendation-list-column-reference"><?php echo $recommendation_in_workunit['unique_identifier']; ?></span>
	<span><?php echo $term->name; ?></span>
	<span class="wp-digi-comment"><?php echo !empty( $recommendation_in_workunit['comment'] ) ? $recommendation_in_workunit['comment'] : ''; ?></span>
	<span class="wp-digi-action">
		<a href="#" data-workunit-id="<?php echo $element->id; ?>" data-id="<?php echo $term_id; ?>" data-index="<?php echo $index; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_load_recommendation_' . $term_id . '_' . $index ); ?>" class="wp-digi-action wp-digi-action-load dashicons dashicons-edit" ></a>
		<a href="#" data-workunit-id="<?php echo $element->id; ?>" data-id="<?php echo $term_id ?>" data-index="<?php echo $index; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_recommendation_' . $term_id . '_' . $index ); ?>" class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
	</span>
</li>
