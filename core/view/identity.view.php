<?php
/**
 * Filter eo button file management display an upload file button
 * Display the unique identifier for the establishment
 * If the establishment is editable : Display the input with the value establishment name
 * Or display the establisment name without an input.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<span
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_right_container' ) ); ?>"
	data-action="load_society"
	data-id="<?php echo esc_attr( $element->data['id'] ); ?>"
	class="<?php echo ! isset( $editable_identity ) ? 'action-attribute' : ''; ?> title">

	<?php if ( Society_Class::g()->get_type() !== $element->data['type'] ) : ?>
		<strong><?php echo esc_html( $element->data['unique_identifier'] ); ?> -</strong>
	<?php endif; ?>

	<?php if ( isset( $editable_identity ) && ( true === $editable_identity ) ) : ?>
		<input type="hidden" name="action" value="save_society" />
		<input type="hidden" name="id" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
		<input type="text" name="title" value="<?php echo esc_attr( $element->data['title'] ); ?>" />
	<?php else : ?>
		<span title="<?php echo esc_attr( $element->data['title'] ); ?>"><?php echo esc_html( $element->data['title'] ); ?></span>
	<?php endif; ?>
</span>
