<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul>
	<?php
	if ( !empty( $list_accronym ) ):
	  foreach ( $list_accronym as $key => $element ):
			\eoxia001\View_Util::exec( 'digirisk', 'setting', 'accronym/item', array( 'key' => $key, 'element' => $element ) );
	  endforeach;
	endif;
	?>
</ul>
