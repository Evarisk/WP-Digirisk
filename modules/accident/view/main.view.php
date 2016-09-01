<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div>
	<?php accident_class::g()->display_accident_list( $society_id ); ?>

	<?php require( ACCIDENT_VIEW_DIR . '/item-new.php' ); ?>
</div>
