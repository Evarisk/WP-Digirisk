<?php
/**
* Filter eo button file management display an upload file button
* Display the unique identifier for the establishment
* If the establishment is editable : Display the input with the value establishment name
* Or display the establisment name without an input.
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package establishment
* @subpackage view
*/
if ( !defined( 'ABSPATH' ) ) exit; ?>

<?php do_shortcode( '[eo_upload_button id=' . $element->id . ' type=' . $element->type . ']' ); ?>

<span
	data-nonce="<?php echo wp_create_nonce( 'load_right_container' ); ?>"
	data-action="load_society"
	data-id="<?php echo $element->id; ?>"
	class="<?php echo !isset( $editable_identity ) ? 'action-attribute' : ''; ?>">
	<strong><?php echo $element->unique_identifier; ?> -</strong>

	<?php if ( isset( $editable_identity ) && ( true === $editable_identity ) ) : ?>
		<input type="text" value="<?php echo $element->title; ?>" name="title" class="wp-digi-input-editable" />
	<?php else: ?>
		<span title="<?php echo $element->title; ?>"><?php echo $element->title; ?></span>
	<?php endif; ?>

</span>
