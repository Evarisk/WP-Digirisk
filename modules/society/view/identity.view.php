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

<span data-nonce="<?php echo wp_create_nonce( 'load_right_container' ); ?>" class="wp-digi-global-name">
	<strong><?php echo $element->unique_identifier; ?> -</strong>

	<?php if ( isset( $editable_identity ) && ( true === $editable_identity ) ) : ?>
		<input type="text" value="<?php echo $element->title; ?>" name="establishment_name" class="wp-digi-input-editable" />
	<?php else: ?>
		<span><?php echo $element->title; ?></span>
	<?php endif; ?>

</span>
