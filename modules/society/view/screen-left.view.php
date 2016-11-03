<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wp-digi-societytree-left-container wp-digi-bloc-loader">
	<?php
	if ( !empty( $group_list ) ):
		group_class::g()->display_toggle( $group_list, $society_parent );
		workunit_class::g()->display_list( $society_parent->id );
	endif;
	?>
</div>
