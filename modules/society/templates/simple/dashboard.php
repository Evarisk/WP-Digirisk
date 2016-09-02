<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wp-digi-societytree-main-container wp-digi-bloc-loader" >
	<div class="wp-digi-societytree-left-container wp-digi-bloc-loader" >
		<?php group_class::g()->display_toggle( $group_list[0] ); ?>
		<?php workunit_class::g()->display_list( $element_id ); ?>
	</div>

	<div class="wp-digi-societytree-right-container wp-digi-bloc-loader">
		<?php do_shortcode( '[digi_dashboard id="' . $element_id . '"]' ); ?>
	</div>
</div>
