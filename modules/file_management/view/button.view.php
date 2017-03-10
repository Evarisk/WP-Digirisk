<?php
/**
 * Contient un bouton qui permet d'ouvrir le media upload de WordPress.
 * Si une image existe déjà, le bouton permet d'ouvrir la gallerie.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package file_management
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<span data-id="<?php echo esc_attr( $id ); ?>"
			data-type="<?php echo esc_attr( $type ); ?>"
			data-title="<?php echo esc_attr( $title ); ?>"
			data-object-name="<?php echo esc_attr( $type ); ?>"
			data-namespace="<?php echo esc_attr( $namespace ); ?>"
			data-action="<?php echo esc_attr( $action ); ?>"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'associate_file' ) ); ?>"
			class="media <?php echo empty( $element->thumbnail_id ) ? esc_attr( 'no-file' ) : ''; ?>">

	<i class="add animated fa fa-plus-circle"></i>
	<?php
	if ( ! empty( $element ) && ! empty( $element->thumbnail_id ) ) :
		echo wp_get_attachment_image( $element->thumbnail_id, 'digirisk-element-miniature', false, array( 'class' => 'wp-post-image wp-digi-element-thumbnail' ) );
	else :
		?>
		<i class="default-image fa fa-picture-o"></i>
		<img src="" class="hidden"/>
		<input class="input-file-image" type="hidden" name="associated_document_id[image][]" />
		<input class="input-file-image" type="hidden" name="thumbnail_id" />
		<?php
	endif;
	?>
</span>
