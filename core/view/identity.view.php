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
	data-id="<?php echo esc_attr( $society->data['id'] ); ?>"
	class="title">

	<?php if ( Society_Class::g()->get_type() !== $society->data['type'] ) : ?>
		<strong><?php echo esc_html( $society->data['unique_identifier'] ); ?> -</strong>
	<?php endif; ?>

		<input type="hidden" name="action" value="save_society" />
		<input type="hidden" name="id" value="<?php echo esc_attr( $society->data['id'] ); ?>" />
		<input type="text" name="title" value="<?php echo esc_attr( $society->data['title'] ); ?>" />
</span>

<div class="wpeo-button button-square-50 button-transparent edit"><i class="button-icon fas fa-pencil-alt"></i></div>
