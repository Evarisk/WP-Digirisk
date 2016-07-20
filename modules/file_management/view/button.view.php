<?php
/**
* Contient un bouton qui permet d'ouvrir le media upload de WordPress.
* Si une image existe déjà, le bouton permet d'ouvrir la gallerie.
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package file_management
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<span data-id="<?php echo $id; ?>" data-object-name="<?php echo $type; ?>" data-nonce="<?php echo wp_create_nonce( 'associate_file' ); ?>" class="wp-digi-element-thumbnail wp-digi-bloc-loader wpeo-upload-media" >
	<?php
  if ( !empty( $element ) && !empty( $element->thumbnail_id ) ):
	   echo wp_get_attachment_image( $element->thumbnail_id, 'element-miniature', false, array( 'class' => 'wp-post-image wp-digi-element-thumbnail', )  );
     echo do_shortcode( "[wpeo_gallery element_id='" . $element->id . "' object_name='". $type . "' ]" );
  else:
    ?>
		<i class="wpeo-upload-media dashicons dashicons-format-image" ></i>
		<img src="#" class="hidden wp-post-image wp-digi-element-thumbnail" />
		<input type="hidden" name="file_id" />
		<?php
  endif;
  ?>
	<div class="mask"><span class="dashicons dashicons-plus"></span></div>
</span>
