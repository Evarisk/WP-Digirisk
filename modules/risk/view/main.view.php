<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-risk wp-digi-table">
	<?php risk_class::g()->display_risk_list( $society_id ); ?>
	<?php view_util::exec( 'risk', 'item-edit', array( 'society_id' => $society_id, 'risk' => $risk ) ); ?>
</ul>
