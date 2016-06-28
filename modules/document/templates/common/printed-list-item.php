<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
	<li data-id="<?php echo $document->id; ?>" class="wp-digi-list-item wp-digi-list-document wp-digi-item-document-<?php echo $document->id; ?>" >
		<span class="wp-digi-reference"><?php echo $document->option[ 'unique_identifier' ]; ?></span>
		<span><?php echo mysql2date( '\T\h\e d F Y \o\n H:i', $document->date, true ); ?></span>
		<span><?php echo $document->title; ?></span>
		<span class="wp-digi-print">
<?php if ( !empty( $document_full_path ) ) : ?>
			<a href="<?php echo $document_full_path; ?>" class="wp-digi-bton-fifth dashicons-before dashicons-download" ><?php _e( 'Download', 'digirisk' ); ?></a>
<?php else: ?>
			<?php _e( 'File does not exists. We are working on re-generation function', 'digirisk' ); ?>
<?php endif; ?>
		</span>
		<span class="wp-digi-action"><a class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" data-global="<?php echo substr( str_replace( 'mdl', 'ctr', get_class( $element ) ), 0, -3 ); ?>" data-parent-id="<?php echo $document->parent_id; ?>" data-id="<?php echo $document->id; ?>" href="#"></a></span>
	</li>
