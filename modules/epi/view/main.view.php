<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-epi wp-digi-table">
	<?php epi_class::g()->display_epi_list( $society_id ); ?>
	<?php require( EPI_VIEW_DIR . '/item-edit.php' ); ?>
</ul>
