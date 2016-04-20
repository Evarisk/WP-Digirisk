<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<li data-id="<?php echo $file_id; ?>" class="wpeofiles-pics-item wpeofiles-pics-mini-gallery-item" >
	<?php echo wp_get_attachment_image( $file_id, ( !empty( $params[ 'picture_size' ] ) ? $params[ 'picture_size' ] : 'thumbnail' ), true, array() ); ?>
</li>
