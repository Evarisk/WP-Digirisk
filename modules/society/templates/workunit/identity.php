<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<span data-nonce="<?php echo wp_create_nonce( 'ajax_file_association_' . $workunit->id ); ?>" data-id="<?php echo $workunit->id; ?>" data-type="<?php echo $workunit->type; ?>" class="wp-digi-element-thumbnail wp-digi-workunit-thumbnail wpeo-upload-media" >
	<?php
	if ( !empty( $workunit->thumbnail_id ) ) :
		echo wp_get_attachment_image( $workunit->thumbnail_id, 'digirisk-element-miniature', false, array( 'class' => 'wp-post-image wp-digi-element-thumbnail', )  );
		echo do_shortcode( "[wpeo_gallery element_id='" . $workunit->id . "' global='workunit_class' ]" );
	else :
	?>
		<i data-nonce="<?php echo wp_create_nonce( 'ajax_file_association_' . $workunit->id ); ?>" data-id="<?php echo $workunit->id; ?>" data-type="<?php echo $workunit->type; ?>" class="wp-digi-element-thumbnail wp-digi-workunit-thumbnail wpeo-upload-media dashicons dashicons-format-image" ></i>
	<?php endif; ?>
</span>

<span class="wp-digi-workunit-name wp-digi-global-name">
	<strong><?php echo $workunit->option[ 'unique_identifier' ]; ?> -</strong>

	<?php if ( isset( $editable_identity ) && ( true === $editable_identity ) ) : ?>
		<input type="text" value="<?php echo $workunit->title; ?>" name="wp-digi-workunit-name" class="wp-digi-input-editable" />
	<?php else: ?>
		<span><?php echo $workunit->title; ?></span>
	<?php endif; ?>
</span>
