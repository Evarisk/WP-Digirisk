<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap risk-page">

	<ul class="wp-digi-list wp-digi-risk wp-digi-table wp-digi-bloc-loader">
		<?php risk_page_class::g()->display_risk_list(); ?>
	</ul>

	<a href="#" class="button button-secondary right">Enregistrer</a>

</div>
