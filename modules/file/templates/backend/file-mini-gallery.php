<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<a href="#" title="<?php _e( 'Set a thumbnail for', 'wpdigi-i18n' ); ?>" class="wpdigi-element-thumbnail alignleft" >
	<?php if ( !empty( $element_thumbnail_id ) ) : ?>
		<?php echo wp_get_attachment_image( $element_thumbnail_id, 'digirisk-element-thumbnail' ); ?>
	<?php else: ?>
		<i class="wpdigi-no-thumnbail dashicons dashicons-format-image" ></i>
	<?php endif; ?>
</a>
<div class="wpeofiles-gallery-container wp-digi-bloc-loader" >
	<?php /**	Laisser ce champs pour les actions javascript / let this input in place for javascripts actions */ ?>
	<input type="hidden" id="wpeo-files-associated-element-type" value="<?php echo $params[ 'element-type' ]; ?>" />
	<input type="hidden" id="wpeo-files-associated-element-id" value="<?php echo $params[ 'element-id' ]; ?>" />
	<input type="hidden" id="wpeo-file-index" value="<?php echo 0; ?>" />
	<input type="hidden" id="wpeo-file-limit" value="<?php echo !empty($params['limit']) ? $params['limit'] : 5; ?>" />

	<ul class="wpeofiles-pics-container wpeofiles-pics-mini-gallery-container" >
		<?php require( wpdigi_utils::get_template_part( WPEOMTM_FILES_DIR, WPEOMTM_FILES_TEMPLATES_MAIN_DIR, "backend", "file", "list" ) ); ?>
	</ul>

	<div class="wp-eo-pagination wpeofiles-paginate">
		<?php echo paginate_links( $args_paginate_links ); ?>
	</div>
</div>
