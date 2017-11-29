<?php
/**
 * The button for upload media.
 *
 * @author Eoxia
 * @since 0.1.0-alpha
 * @version 1.0.0
 * @copyright 2017
 * @package EO-Framework/EO-Upload
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<span data-id="<?php echo esc_attr( $element->id ); ?>"
			<?php echo WPEO_Upload_Class::g()->out_all_attributes( $atts ); // WPCS: XSS is ok. ?>
			data-nonce="<?php echo esc_attr( wp_create_nonce( $nonce_name ) ); ?>"
			class="media <?php echo esc_attr( $no_file_class . ' ' . $atts['custom_class'] ); ?>">
	<i class="button-add animated fa fa-plus-circle"></i>

	<?php
	if ( ! empty( $main_picture_id ) ) :
		if ( 'image' === $atts['mime_type'] ) :
			echo wp_get_attachment_image( $main_picture_id, $atts['size'] );
		else :
			?>
			<div class="document">
				<i class="icon fa fa-paperclip" aria-hidden="true"></i>
			</div>
			<?php
		endif;
	else :
		if ( 'image' === $atts['mime_type'] ) :
		?>
		<div class="default">
			<i class="default-image fa fa-picture-o"></i>
			<img src="" class="hidden"/>
		</div>
		<?php
		else :
			?>
			<div class="document">
				<i class="icon fa fa-paperclip" aria-hidden="true"></i>
			</div>
			<?php
		endif;
		?>
		<input type="hidden" name="<?php echo esc_attr( $atts['field_name'] ); ?>" />
		&nbsp;
	<?php endif; ?>
</span>
