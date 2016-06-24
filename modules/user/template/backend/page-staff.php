<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wpdigi-staff <?php echo empty( $hidden ) ? 'wrap' : 'hidden'; ?>">
	<h3><?php _e( 'Import staff' , 'wpdigi-i18n' ); ?></h3>

	<ul class="wp-digi-form no-form gridwrapper3 single-line">
		<li></li>
		<li></li>
		<li class="form-element">
			<label><?php _e( 'Domain mail', 'wpdigi-i18n' ); ?>
				<input class="input-domain-mail" type="text" value="<?php echo get_option( 'digirisk_domain_mail', 'demo.com' ); ?>" />
			</label>
			<a href="#" data-nonce="<?php echo wp_create_nonce( 'save_domain_mail' ); ?>" class="wp-digi-action wp-digi-action-save-domain-mail dashicons dashicons-edit"></a>

		</li>
	</ul>

	<!-- Liste les utilisateurs -->
	<ul class="wp-digi-list wp-digi-table wp-digi-list-staff wp-digi-bloc-loader">
		<li class="wp-digi-table-header" >
			<span></span>
			<span><?php _e('ID', 'wpdigi-i18n'); ?></span>
			<span><?php _e('Lastname', 'wpdigi-i18n'); ?></span>
			<span><?php _e('Firtname', 'wpdigi-i18n'); ?></span>
			<span><?php _e('Email', 'wpdigi-i18n'); ?></span>
			<span></span>
		</li>

		<?php
		if ( !empty( $list_user ) ):
			foreach ( $list_user as $user ):
				require( wpdigi_utils::get_template_part( DIGI_INSTAL_DIR, DIGI_INSTAL_TEMPLATES_MAIN_DIR, 'backend', 'list', 'item' ) );
			endforeach;
		endif;
		?>
	</ul>

	<div class="wp-digi-list-item wp-digi-table-item-new">
		<form method="POST" id="wp-digi-form-add-staff" class="wp-digi-form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
			<ul class="wp-digi-table">
				<li>
					<input type="hidden" name="action" value="wpdigi-installer-add-user" />
					<?php wp_nonce_field( 'ajax_installer_add_user' ); ?>
					<span class="wp-avatar" style="background: #FFF;" ></span>
					<span></span>
					<span class="padded"><input type="text" placeholder="Name" name="user[option][user_info][lastname]" /></span>
					<span class="padded"><input type="text" placeholder="Firstname" name="user[option][user_info][firstname]" /></span>
					<span class="padded"><input type="text" placeholder="demo@demo.com" name="user[email]" /></span>
					<span class="add-staff wp-digi-action wp-digi-action-new" ><a href="#" class="wp-digi-action dashicons dashicons-plus" ></a></span>
				</li>
			</ul>
		</form>
	</div>

		<!-- <a href="#" class="more-option wp-digi-action"><i class="dashicons dashicons-plus"></i><?php _e( 'More options', 'wpdigi-i18n' );?></a>

		<ul class="row gridwrapper4 hidden">
			<li class="form-element"><label><?php _e( 'Social security number', 'wpdigi-i18n' ); ?><input type="text" name="user[option][user_info][social_security_number]" /></label></li>
			<li class="form-element"><label><?php _e( 'Address', 'wpdigi-i18n' ); ?><input type="text" name="address[address]" /></label></li>
			<li class="form-element"><label><?php _e( 'Hiring date', 'wpdigi-i18n' ); ?><input type="text" name="user[option][user_info][hiring_date]" class="wpdigi_date" /></label></li>
			<li class="form-element"><label><?php _e( 'Job', 'wpdigi-i18n' ); ?><input type="text" name="user[option][user_info][job]" /></label></li>
			<li class="form-element"><label><?php _e( 'Birthday', 'wpdigi-i18n' ); ?><input type="text" name="user[option][user_info][birthday]" class="wpdigi_date" /></label></li>
			<li class="form-element"><label><?php _e( 'Additional adress', 'wpdigi-i18n' ); ?><input type="text" name="address[additional_address]" /></label></li>
			<li class="form-element"><label><?php _e( 'Release date of society', 'wpdigi-i18n' ); ?><input type="text" name="user[option][user_info][release_date_of_society]" class="wpdigi_date" /></label></li>
			<li class="form-element"><label><?php _e( 'Professional qualification', 'wpdigi-i18n' ); ?><input type="text" name="user[option][user_info][professional_qualification]" /></label></li>
			<li class="form-element"><label><?php _e( 'Sex', 'wpdigi-i18n' ); ?><input type="text" name="user[option][user_info][sexe]" /></label></li>
			<li class="form-element"><label><?php _e( 'Postcode', 'wpdigi-i18n' ); ?><input type="text" name="address[postcode]" /></label></li>
			<li class="form-element"><label><?php _e( 'Insurance compagny', 'wpdigi-i18n' ); ?><input type="text" name="user[option][user_info][insurance_compagny]" /></label></li>
			<li class="form-element"><label><?php _e( 'Nationality', 'wpdigi-i18n' ); ?><input type="text" name="user[option][user_info][nationality]" /></label></li>
			<li class="form-element"><label><?php _e( 'Town', 'wpdigi-i18n' ); ?><input type="text" name="address[town]" /></label></li>
		</ul> -->

	<!--<a href="#" class="add-staff wp-digi-action wp-digi-bton-first float right"><i class="dashicons dashicons-plus"></i><?php _e( 'Add', 'wpdigi-i18n' ); ?></a>-->

	<form enctype="multipart/form-data" action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
		<div class="hidden wp-digi-add-staff-from-file">
			<!-- Importer le personel depuis un fichier -->
			<h3><?php _e( 'Add staff from file', 'wpdigi-i18n' ); ?></h3>

			<a href="<?php echo WPDIGI_URL; ?>/core/assets/document_template/import_des_utilisateurs.ods"><?php _e( 'You can download the file for build the import here', 'wpdigi-i18n' );?></a>
			<p><?php _e( 'Each lines will have the following format :', 'wpdigi-i18n' ); ?></p>
			<p><?php _e( 'The fields Firstname and Mail are mandatory', 'wpdigi-i18n' ); ?></p>
			<p><?php _e( 'You do not have to fill in all fields but all separator must be present. Exemple username;;;;mail;;;;;;;;;;;', 'wpdigi-i18n' ); ?></p>
			<input type="hidden" name="action" value="wpdigi-installer-import-staff" />
			<?php wp_nonce_field( 'post_installer_import_staff' ); ?>
			<textarea name="content_csv"></textarea>
			<input type="file" name="csv" />
		</div>
		<!--<input type="submit" class="wp-digi-bton-fourth float right" value="<?php _e( 'Import staff', 'wpdigi-i18n' ); ?>" />-->
	</form>


	<a href="<?php echo admin_url( 'admin.php?page=digirisk-simple-risk-evaluation' ); ?>" class="float right <?php echo empty( $hidden ) ? 'hidden' : 'wp-digi-bton-fourth'; ?>"><?php _e( 'Save', 'wpdigi-i18n' ); ?></a>
</div>
