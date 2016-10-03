<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<section class="gridwrapper2">
	<!-- Le bloc des utilisateurs affectés -->
	<div>
		<?php do_shortcode( '[digi-search id="' . $element->id . '" icon="dashicons dashicons-search" next-action="display_evaluator_affected" type="user" target="wp-digi-list-evaluator"]' ); ?>
		<!-- La liste des utilisateurs affectés -->
		<?php view_util::exec( 'evaluator', 'list-affected-evaluator', array( 'element' => $element, 'element_id' => $element->id, 'current_page' => $current_page, 'number_page' => $number_page, 'list_affected_evaluator' => $list_affected_evaluator ) ); ?>
	</div>

	<!-- Le bloc des utilisateurs à affecter -->
	<div>
		<?php do_shortcode( '[digi-search id="' . $element->id . '" icon="dashicons dashicons-search" next-action="display_evaluator_to_assign" type="user" target="wp-form-evaluator-to-assign"]' ); ?>
		<!-- La liste des utilisateurs à affecter -->
		<?php view_util::exec( 'evaluator', 'list-evaluator-to-assign', array( 'element' => $element, 'element_id' => $element->id, 'current_page' => $current_page, 'number_page' => $number_page, 'list_evaluator_to_assign' => $list_evaluator_to_assign ) ); ?>
	</div>
</section>
