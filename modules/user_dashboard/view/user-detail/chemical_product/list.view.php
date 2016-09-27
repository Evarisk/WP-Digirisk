<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-table wp-digi-bloc-loader">
	<li class="wp-digi-table-header">
		<span></span>
		<span><?php _e('ID', 'digirisk'); ?></span>
		<span><?php _e('Nom unité', 'digirisk'); ?></span>
		<span><?php _e('Groupement lié', 'digirisk'); ?></span>
		<span><?php _e('Date d\'affectation', 'digirisk'); ?></span>
		<span></span>
	</li>

	<?php
	if ( !empty( $list_element ) ):
		foreach ( $list_element as $element ):
			require( USER_DASHBOARD_VIEW . '/user-detail/workunit/item.view.php' );
		endforeach;
	endif;
	?>
</ul>
