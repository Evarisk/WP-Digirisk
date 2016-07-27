<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div>
	<?php accident_class::get()->display_accident_list( $society_id ); ?>

	<?php require( ACCIDENT_VIEW_DIR . '/item-new.php' ); ?>
</div>
