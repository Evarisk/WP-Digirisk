<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div>
	<?php epi_class::g()->display_epi_list( $society_id ); ?>

	<?php require( EPI_VIEW_DIR . '/item-new.php' ); ?>
</div>
