<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

	<?php recommendation_class::g()->display_recommendation_list( $society_id ); ?>
	<?php view_util::exec( 'recommendation', 'item-edit', array( 'society_id' => $society_id, 'recommendation' => $recommendation, 'index' => $index ) ); ?>
</ul>
