<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<section class="gridwrapper2">
	<!-- Le bloc des utilisateurs affectés -->
	<div>
		<!-- La barre de recherche -->
		<label for="user_name_affected" class="wp-list-search">
			<i class="dashicons dashicons-search"></i>
			<input type="text" placeholder="<?php _e( 'Write here to search...', 'wpdigi-i18n' ); ?>" class="wpdigi-auto-complete-user" data-append-to=".wp-digi-list-evaluator" data-element-id="<?php echo $workunit->id; ?>" data-callback="wpdigi_evaluator_ctr_01::display_evaluator_affected_in_workunit" />
		</label>

		<!-- La liste des utilisateurs affectés -->
		<?php require_once( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) ); ?>
	</div>

	<!-- Le bloc des utilisateurs à affecter -->
	<div>
		<!-- La barre de recherche -->

		<label for="user_name_to_assign" class="wp-list-search">
			<i class="dashicons dashicons-search"></i>
			<input type="text" placeholder="<?php _e( 'Write here to search...', 'wpdigi-i18n' ); ?>" class="wpdigi-auto-complete-user" data-append-to=".wp-form-evaluator-to-assign" data-element-id="<?php echo $workunit->id; ?>" data-callback="wpdigi_evaluator_ctr_01::display_evaluator_to_assign" />
		</label>


		<!-- La liste des utilisateurs à affecter -->
		<?php require_once( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-user-to-assign' ) ); ?>
	</div>
</section>
