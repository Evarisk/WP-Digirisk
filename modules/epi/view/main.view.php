<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div>
	<?php epi_class::get()->display_epi_list( $society_id ); ?>

	<?php require( EPI_VIEW_DIR . '/item-new.php' ); ?>
</div>
