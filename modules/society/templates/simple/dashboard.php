<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wp-digi-societytree-main-container wp-digi-bloc-loader" >
	<div class="wp-digi-societytree-left-container wp-digi-bloc-loader" >
		<!-- Display society tree -->
		<?php group_class::get()->display_society_tree( $display_mode ); ?>
	</div>


	<div class="wp-digi-societytree-right-container wp-digi-bloc-loader">
		<?php do_shortcode( '[digi_dashboard id="' . $element_id . '"]' ); ?>
	</div>
</div>
