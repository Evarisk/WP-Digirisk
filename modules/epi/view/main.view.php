<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-epi wp-digi-table">
	<?php epi_class::g()->display_epi_list( $society_id ); ?>
	<?php view_util::exec( 'epi', 'item-edit', array( 'society_id' => $society_id, 'epi' => $epi ) ); ?>
</ul>
