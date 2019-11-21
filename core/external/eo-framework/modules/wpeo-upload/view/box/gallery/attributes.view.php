<?php
/**
 * Attributes of HTMLElement for AJAX.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2017-2018 Eoxia
 * @package EO_Framework\EO_Upload\Gallery\View
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

data-id="<?php echo esc_attr( $data['id'] ); ?>"
data-title="<?php echo esc_attr( $data['title'] ); ?>"
data-mode="<?php echo esc_attr( $data['mode'] ); ?>"
data-field-name="<?php echo esc_attr( $data['field_name'] ); ?>"
data-model-name="<?php echo esc_attr( $data['model_name'] ); ?>"
data-custom-class="<?php echo esc_attr( $data['custom_class'] ); ?>"
data-size="<?php echo esc_attr( $data['size'] ); ?>"
data-single="<?php echo esc_attr( $data['single'] ); ?>"
data-mime-type="<?php echo esc_attr( $data['mime_type'] ); ?>"
data-display-type="<?php echo esc_attr( $data['display_type'] ); ?>"
