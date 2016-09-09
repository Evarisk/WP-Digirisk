<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wp-digi-societytree-left-container wp-digi-bloc-loader" >
	<?php
	if ( !empty( $group_list ) ):
		group_class::g()->display_toggle( $group_list, $society );
		workunit_class::g()->display_list( $element_id );
		?>
		<button data-id="<?php echo $element_id; ?>" class="wp-digi-duer-form-display wp-digi-bton-fifth dashicons-before dashicons-share-alt2"><?php _e( 'Print DUER', 'digirisk' ); ?></button>
		<?php
	endif;
	?>
</div>
