<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div data-id="<?php echo $element_id; ?>" class="wpeo-gallery hidden">

  <a href="#" class="close"><i class="dashicons dashicons-no-alt"></i></a>

  <?php if ( !empty( $list_id ) ): ?>
    <ul class="image-list">
    <?php foreach ( $list_id as $key => $id ): ?>
      <li data-id="<?php echo $id; ?>" class="<?php echo $key == 0 ? 'current' : 'hidden'; ?>"><?php echo wp_get_attachment_image( $id, "full" ); ?></li>
    <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <ul class="navigation">
    <li><a href="#" class="prev"><i class="dashicons dashicons-arrow-left-alt2"></i></a></li>
    <li><a href="#" class="next"><i class="dashicons dashicons-arrow-right-alt2"></i></a></li>
  </ul>

  <ul class="action">
    <li><a href="#" class="wp-digi-bton-fourth set-as-thumbnail"><?php _e( 'Set as default thumbnail', 'wpdigi-i18n' ); ?></a></li>
    <li><a href="#" data-nonce="<?php echo wp_create_nonce( 'ajax_file_association_' . $element_id ); ?>" data-id="<?php echo $element_id; ?>" data-type="<?php echo ${$params['global']}->get_post_type(); ?>" class="wp-digi-bton-first wpeo-upload-media" ><i></i><?php _e( 'Add a new picture', 'wpdigi-i18n' ); ?></a></li>
  </ul>

</div>
