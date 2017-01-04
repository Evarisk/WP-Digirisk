<?php
/**
 * Filter eo button file management display an upload file button
 * Display the unique identifier for the establishment
 * If the establishment is editable : Display the input with the value establishment name
 * Or display the establisment name without an input.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.3.0
 * @copyright 2015-2016 Eoxia
 * @package establishment
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<span
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_right_container' ) ); ?>"
	data-action="load_society"
	data-id="<?php echo esc_attr( $element->id ); ?>"
	class="<?php echo ! isset( $editable_identity ) ? 'action-attribute' : ''; ?> title">
	<strong><?php echo esc_html( $element->unique_identifier ); ?> -</strong>

	<?php if ( isset( $editable_identity ) && ( true === $editable_identity ) ) : ?>
		<input type="hidden" name="action" value="save_society" />
		<input type="hidden" name="id" value="<?php echo esc_attr( $element->id ); ?>" />
		<input type="text" name="title" value="<?php echo esc_attr( $element->title ); ?>" />
	<?php else : ?>
		<span title="<?php echo esc_attr( $element->title ); ?>"><?php echo esc_html( $element->title ); ?></span>
	<?php endif; ?>

</span>
