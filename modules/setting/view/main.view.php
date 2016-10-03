<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap">
	<h1><?php _e( 'Digirisk settings', 'digirisk' ); ?></h1>
	<?php view_util::exec( 'setting', 'accronym/form', array( 'list_accronym' => $list_accronym ) ); ?>
</div>
