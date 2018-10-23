<?php
/**
 * The link for upload media.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.2.0
 * @version 1.2.0
 * @copyright 2017-2018 Eoxia
 * @package EO_Framework\EO_Upload\List\View
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-upload-<?php echo esc_attr( $atts['display_type'] ); ?>">

	<?php if ( 'edit' === $atts['mode'] ) : ?>
		<a href="#"
			class="upload"
			data-id="<?php echo esc_attr( $element->data['id'] ); ?>"
			data-model-name="<?php echo esc_attr( $atts['model_name'] ); ?>"
			data-field-name="<?php echo esc_attr( $atts['field_name'] ); ?>"
			data-custom-class="<?php echo ! empty( $atts['custom_class'] ) ? esc_attr( $atts['custom_class'] ) : ''; ?>"
			data-single="<?php echo esc_attr( $atts['single'] ); ?>"
			data-mime-type="<?php echo esc_attr( $atts['mime_type'] ); ?>"
			data-size="<?php echo esc_attr( $atts['size'] ); ?>"
			data-display-type="<?php echo esc_attr( $atts['display_type'] ); ?>">
			<i class="far fa-plus" aria-hidden="true"></i>
			<?php esc_html_e( 'Add an attached file', 'wpeo-upload' ); ?></a>
	<?php endif; ?>
		<?php require( \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->path . '/view/' . $atts['display_type'] . '/list.view.php' ); ?>
</div>
