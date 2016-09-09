<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul>
	<?php
	if ( !empty( $list_accronym ) ):
	  foreach ( $list_accronym as $key => $element ):
			require( SETTING_VIEW_DIR . '/accronym/item.view.php' );
	  endforeach;
	endif;
	?>
</ul>
