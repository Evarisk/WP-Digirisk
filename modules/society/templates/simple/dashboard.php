<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wp-digi-societytree-main-container wp-digi-clearer" >
	<div class="wp-digi-societytree-left-container" >
		<!-- Display society tree -->
		<?php global $wpdigi_group_ctr; $wpdigi_group_ctr->display_society_tree( $display_mode ); ?>
	</div>

	<div class="wp-digi-societytree-right-container wp-digi-bloc-loader" ><?php echo apply_filters( 'wpdigi_default_dashboard_content', '' ); ?></div>
</div>
