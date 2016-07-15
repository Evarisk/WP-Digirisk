<?php
/**
* La gallerie d'image avec bouton de navigation
* Avec deux bouton :
* Set as default thumbnail : Pour mettre l'image par défaut
* Add a new picture : Permet d'ajouter une nouvelle image à la gallerie
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package file_management
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div data-id="<?php echo $element_id; ?>" class="wpeo-gallery" style="display: none!important;">

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
    <li><a href="#" class="wp-digi-bton-fourth set-as-thumbnail"><?php _e( 'Set as default thumbnail', 'digirisk' ); ?></a></li>
    <li><a href="#" data-nonce="<?php echo wp_create_nonce( 'associate_file' ); ?>" data-id="<?php echo $element_id; ?>" data-object-name="<?php echo $param['object_name']; ?>" class="custom wp-digi-bton-first wpeo-upload-media" ><i></i><?php _e( 'Add a new picture', 'digirisk' ); ?></a></li>
  </ul>

</div>
