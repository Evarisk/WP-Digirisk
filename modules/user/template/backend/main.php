<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<section class="gridwrapper2">
	<!-- Le bloc des utilisateurs affectés -->
	<div>
		<!-- La barre de recherche -->
		<label for="user_name_affected" class="wp-list-search">
			<i class="dashicons dashicons-search"></i>
			<input type="text" placeholder="<?php _e( 'Write here to search...', 'wpdigi-i18n' ); ?>" class="wpdigi-auto-complete-user" data-append-to=".wp-digi-list-affected-user" data-element-id="<?php echo $workunit->id; ?>" data-filter="wpdigi_search_user_affected" />
		</label>

		<!-- La liste des utilisateurs affectés -->
		<?php require_once( wpdigi_utils::get_template_part( WPDIGI_USERS_DIR, WPDIGI_USERS_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) ); ?>
	</div>

	<!-- Le bloc des utilisateurs à affecter -->
	<div>
		<!-- La barre de recherche -->
		<label for="user_name_to_assign" class="wp-list-search">
			<i class="dashicons dashicons-search"></i>
			<input type="text" placeholder="<?php _e( 'Write here to search...', 'wpdigi-i18n' ); ?>" class="wpdigi-auto-complete-user" data-append-to=".wp-form-user-to-assign" data-element-id="<?php echo $workunit->id; ?>" data-filter="wpdigi_search_user_to_assign" />
		</label>

		<!-- La liste des utilisateurs à affecter -->
		<?php require_once( wpdigi_utils::get_template_part( WPDIGI_USERS_DIR, WPDIGI_USERS_TEMPLATES_MAIN_DIR, 'backend', 'list-user-to-assign' ) ); ?>
	</div>
</section>
