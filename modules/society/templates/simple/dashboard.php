<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wp-digi-societytree-main-container wp-digi-clearer" >
	<div class="wp-digi-societytree-left-container" >
		<!-- Display society tree -->
		<?php group_class::get()->display_society_tree( $display_mode ); ?>
	</div>


	<div class="wp-digi-societytree-right-container">
		<?php do_shortcode( '[digi_dashboard id="' . $element_id . '"]' ); ?>
	</div>
</div>
