<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<section class="gridwrapper2">
	<!-- Le bloc des utilisateurs affectés -->
	<div>


		<!-- La liste des utilisateurs affectés -->
		<?php require_once( wpdigi_utils::get_template_part( WPDIGI_USERS_DIR, WPDIGI_USERS_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) ); ?>
	</div>

	<!-- Le bloc des utilisateurs à affecter -->
	<div>


		<!-- La liste des utilisateurs à affecter -->
		<?php require_once( wpdigi_utils::get_template_part( WPDIGI_USERS_DIR, WPDIGI_USERS_TEMPLATES_MAIN_DIR, 'backend', 'list-user-to-assign' ) ); ?>
	</div>
</section>
