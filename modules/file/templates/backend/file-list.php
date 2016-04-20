<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<?php if ( !empty( $files ) ) : ?>
	<?php foreach ( $files as $file_id ) : ?>
		<?php $file_id = (int)$file_id;
		<?php if ( !empty( $file_id ) && ( empty( $params ) || empty( $params[ 'type' ] ) || ( 'image' == $params[ 'type' ] && wp_attachment_is_image( $file_id ) ) ) ) : ?>
		<?php require( wpdigi_utils::get_template_part( WPEOMTM_FILES_DIR, WPEOMTM_FILES_TEMPLATES_MAIN_DIR, 'backend', 'file' ) ); ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>

<li data-nonce="<?php echo wp_create_nonce( "ajax_file_association_" . $params[ 'element-id' ] ); ?>" data-uploader_button_text="<?php _e( 'Associate', 'wpdigi-i18n' ); ?>" data-uploader_title="<?php _e( 'Associate file to element', 'wpdigi-i18n' ); ?>" data-id="<?php echo $params[ 'element-id' ]; ?>" data-type="<?php echo ( !empty( $params ) && !empty( $params[ 'element-type' ] ) ? $params[ 'element-type' ] : 'post' ); ?>" class="wpeofiles-pics-item wpeofiles-pics-new-item wp-digi-action-new wpeo-upload-media" >
	<a href="#" class="wp-digi-action dashicons dashicons-plus" ></a>
</li>
