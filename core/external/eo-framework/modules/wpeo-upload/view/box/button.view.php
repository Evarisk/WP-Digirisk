<?php
/**
 * The button for upload media.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 0.1.0-alpha
 * @version 1.0.0
 * @copyright 2017-2018 Eoxia
 * @package EO_Framework\EO_Upload\View
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<span data-id="<?php echo esc_attr( $element->data['id'] ); ?>"
			<?php echo WPEO_Upload_Class::g()->out_all_attributes( $atts ); // WPCS: XSS is ok. ?>
			data-nonce="<?php echo esc_attr( wp_create_nonce( $nonce_name ) ); ?>"
			class="media <?php echo esc_attr( $no_file_class . ' ' . $atts['custom_class'] ); ?>">
	<i class="button-add animated fas fa-plus-circle"></i>

	<?php
	if ( ! empty( $main_picture_id ) ) :
		if ( 'image' === $atts['mime_type'] ) :
			echo wp_get_attachment_image( $main_picture_id, $atts['size'] );
		else :
			?>
			<div class="document default-icon-container">
				<i class="icon fas fa-paperclip" aria-hidden="true"></i>
			</div>
			<?php
		endif;
	else :
		if ( 'image' === $atts['mime_type'] ) :
		?>
		<div class="default default-icon-container">
			<i class="default-image fas fa-image"></i>
			<img src="" class="hidden"/>
		</div>
		<?php
		else :
			?>
			<div class="document default-icon-container">
				<i class="icon fas fa-paperclip" aria-hidden="true"></i>
			</div>
			<?php
		endif;
		?>
		<input type="hidden" name="<?php echo esc_attr( $atts['field_name'] ); ?>" />
	<?php endif; ?>
</span>
