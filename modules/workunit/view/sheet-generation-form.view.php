<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post" id="wpdigi-save-element-form" >
	<input type="hidden" name="action" value="wpdigi_save_sheet<?php echo ( !empty( $element ) && !empty( $element->type ) ? '_' . $element->type : '' ); ?>" />
	<?php wp_nonce_field( 'digi_ajax_generate_element_sheet' ); ?>
	<input type="hidden" name="element_id" value="<?php echo $element->id; ?>" />
	<input type="hidden" name="element_type" value="<?php echo $element->type; ?>" />

	<div class="wp-digi-save-sheet-container">
		<?php _e( 'Click the button to save your current sheet', 'digirisk' ); ?>
		<button class="wp-digi-bton-fourth" id="wpdigi-save-element-sheet" ><?php _e( 'Save sheet', 'digirisk' ); ?></button>
	</div>
</form>
