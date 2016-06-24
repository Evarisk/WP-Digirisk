<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<section class="gridwrapper2">
	<!-- Le bloc des utilisateurs affectés -->
	<div>
		<!-- La barre de recherche -->


		<!-- La liste des utilisateurs affectés -->
		<?php require_once( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) ); ?>
	</div>

	<!-- Le bloc des utilisateurs à affecter -->
	<div>
		<!-- La barre de recherche -->


		<!-- La liste des utilisateurs à affecter -->
		<?php require_once( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-user-to-assign' ) ); ?>
	</div>
</section>
