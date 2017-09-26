<?php
/**
 * Filter eo button file management display an upload file button
 * Display the unique identifier for the establishment
 * If the establishment is editable : Display the input with the value establishment name
 * Or display the establisment name without an input.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<span
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_right_container' ) ); ?>"
	data-action="load_society"
	data-id="<?php echo esc_attr( $element->id ); ?>"
	class="<?php echo ! isset( $editable_identity ) ? 'action-attribute' : ''; ?> title">

	<?php if ( Society_Class::g()->get_post_type() !== $element->type ) : ?>
		<strong><?php echo esc_html( $element->unique_identifier ); ?> -</strong>
	<?php endif; ?>

	<?php if ( isset( $editable_identity ) && ( true === $editable_identity ) ) : ?>
		<input type="hidden" name="action" value="save_society" />
		<input type="hidden" name="id" value="<?php echo esc_attr( $element->id ); ?>" />
		<input type="text" name="title" value="<?php echo esc_attr( $element->title ); ?>" />
	<?php else : ?>
		<span title="<?php echo esc_attr( $element->title ); ?>"><?php echo esc_html( $element->title ); ?></span>
	<?php endif; ?>

</span>
