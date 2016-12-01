<?php namespace digi;
/**
* Contient un bouton qui permet d'ouvrir le media upload de WordPress.
* Si une image existe déjà, le bouton permet d'ouvrir la gallerie.
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package file_management
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<span data-id="<?php echo $id; ?>" data-type="<?php echo $type; ?>" data-title="<?php echo $title; ?>" data-object-name="<?php echo $type; ?>" data-action="<?php echo $action; ?>" data-nonce="<?php echo wp_create_nonce( 'associate_file' ); ?>" class="wp-digi-element-thumbnail wp-digi-bloc-loader wpeo-upload-media" >
	<?php
  if ( !empty( $element ) && !empty( $element->thumbnail_id ) ):
	   echo wp_get_attachment_image( $element->thumbnail_id, 'thumbnail', false, array( 'class' => 'wp-post-image wp-digi-element-thumbnail', )  );
     echo do_shortcode( "[wpeo_gallery element_id='" . $element->id . "' action='" . $action . "' object_name='". $type . "' ]" );
  else:
    ?>
		<?php echo $title; ?>
		<i class="wpeo-upload-media dashicons dashicons-format-image" ></i>
		<img src="#" class="hidden wp-post-image wp-digi-element-thumbnail" />
		<input class="input-file-image" type="hidden" name="associated_document_id[image][]" />
		<input class="input-file-image" type="hidden" name="thumbnail_id" />
		<?php
  endif;
  ?>
	<div class="mask"><span class="dashicons dashicons-plus"></span></div>
</span>
