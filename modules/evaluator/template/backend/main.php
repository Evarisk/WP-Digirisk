<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<section class="gridwrapper2">
	<!-- Le bloc des utilisateurs affectés -->
	<div>
		<?php do_shortcode( '[digi-search id="' . $element->id . '" icon="dashicons dashicons-search" next-action="display_evaluator_affected" type="user" target="wp-digi-list-evaluator"]' ); ?>
		<!-- La liste des utilisateurs affectés -->
		<?php require( WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR . 'backend/list-affected-user.php' ); ?>
	</div>

	<!-- Le bloc des utilisateurs à affecter -->
	<div>
		<?php do_shortcode( '[digi-search id="' . $element->id . '" icon="dashicons dashicons-search" next-action="display_evaluator_to_assign" type="user" target="wp-form-evaluator-to-assign"]' ); ?>
		<!-- La liste des utilisateurs à affecter -->
		<?php require( WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR . 'backend/list-user-to-assign.php' ); ?>
	</div>
</section>
