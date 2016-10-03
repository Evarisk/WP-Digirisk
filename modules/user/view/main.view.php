<?php namespace digi;
 if ( !defined( 'ABSPATH' ) ) exit; ?>

<section class="gridwrapper2">
	<!-- Le bloc des utilisateurs affectés -->
	<div>
		<?php do_shortcode( '[digi-search id="' . $workunit->id . '" icon="dashicons dashicons-search" next-action="display_user_affected" type="user" target="wp-digi-list-affected-user"]' ); ?>
		<!-- La liste des utilisateurs affectés -->
		<?php view_util::exec( 'user', 'list-affected-user', array( 'workunit' => $workunit, 'list_affected_user' => $list_affected_user, ) ); ?>
	</div>

	<!-- Le bloc des utilisateurs à affecter -->
	<div>

		<?php do_shortcode( '[digi-search id="' . $workunit->id . '" icon="dashicons dashicons-search" next-action="display_user_assigned" type="user" target="wp-form-user-to-assign"]' ); ?>
		<!-- La liste des utilisateurs à affecter -->
		<?php view_util::exec( 'user', 'list-user-to-assign', array( 'workunit' => $workunit, 'current_page' => $current_page, 'number_page' => $number_page, 'list_user_to_assign' => $list_user_to_assign, 'list_affected_id' => $list_affected_id ) ); ?>
	</div>
</section>
