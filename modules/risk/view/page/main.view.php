<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap">

	<ul class="wp-digi-list wp-digi-risk wp-digi-table">
		<?php risk_page_class::g()->display_risk_list(); ?>
	</ul>

</div>
