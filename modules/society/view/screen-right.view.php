<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wp-digi-societytree-right-container wp-digi-bloc-loader">
	<?php
	if ( !empty( $group_list ) ):
		do_shortcode( '[digi_dashboard id="' . $element_id . '"]' );
	endif;
	?>
</div>
