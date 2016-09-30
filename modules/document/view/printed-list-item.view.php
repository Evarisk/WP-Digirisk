<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<li data-id="<?php echo $element->id; ?>" class="wp-digi-list-item wp-digi-list-document wp-digi-item-document-<?php echo $element->id; ?>" >
	<span class="wp-digi-reference"><?php echo $element->unique_identifier; ?></span>
	<span><?php echo mysql2date( '\T\h\e d F Y \o\n H:i', $element->date, true ); ?></span>
	<span><?php echo $element->title; ?></span>

	<span class="wp-digi-print">
		<a href="<?php echo document_class::g()->get_document_path( $element ); ?>" class="wp-digi-bton-fifth dashicons-before dashicons-download" ><?php _e( 'Download', 'digirisk' ); ?></a>
	</span>

	<?php if ( 'application/vnd.oasis.opendocument.text' == $element->mime_type ) : ?>
		<span class="wp-digi-action"><a class="wp-digi-action wp-digi-action-regenerate dashicons dashicons-image-rotate" data-nonce="<?php echo wp_create_nonce( 'wpdigi_regenerate_document' ); ?>" title="<?php _e( 'Regenerate the document', 'digirisk' ); ?>" data-parent-id="<?php echo $element->parent_id; ?>" data-id="<?php echo $element->id; ?>" href="#"></a></span>
	<?php else: ?>
		<span class="wp-digi-action"><a class="wp-digi-action dashicons" href="#"></a></span>
	<?php endif; ?>
	<span class="wp-digi-action"><a class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" data-parent-id="<?php echo $element->parent_id; ?>" data-id="<?php echo $element->id; ?>" href="#"></a></span>
</li>
