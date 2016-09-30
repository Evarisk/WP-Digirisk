<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<form method="post" class="wp-digi-list-item wp-digi-table-item-edit wp-digi-recommendation-item" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
	<input type="hidden" name="action" value="wpdigi-edit-recommendation" />
	<input type="hidden" name="workunit_id" value="<?php echo $workunit_id; ?>" />
	<input type="hidden" name="term_id" value="<?php echo $term_id; ?>" />
	<input type="hidden" name="index" value="<?php echo $index; ?>" />
	<?php wp_nonce_field( 'ajax_edit_recommendation_' . $term_id . '_' . $index ); ?>
	<span class="wp-digi-recommendation-list-column-thumbnail"><?php echo wp_get_attachment_image( $term->thumbnail_id, 'thumbnail', false, array( 'title' => $term->name ) ); ?></span>
	<span class="wp-digi-recommendation-list-column-reference"><?php echo $recommendation_in_workunit['unique_identifier']; ?></span>
	<span><?php echo $term->name; ?></span>
	<span class="wp-digi-comment"><input name="recommendation_comment" type="text" value="<?php echo !empty( $recommendation_in_workunit['comment'] ) ? $recommendation_in_workunit['comment'] : ''; ?>" /></span>
	<span class="wp-digi-action">
		<a href="#" data-workunit-id="<?php echo $workunit_id; ?>" data-id="<?php echo $term_id; ?>" data-index="<?php echo $index; ?>" class="wp-digi-action-edit fa fa-floppy-o" aria-hidden="true"></a>
	</span>
</form>
