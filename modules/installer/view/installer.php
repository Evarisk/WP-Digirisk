<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wpdigi-installer">
	<h2><?php _e( 'Digirisk', 'digirisk' ); ?></h2>

	<ul class="step">
		<li class="active"><span><?php _e( 'Your informations', 'digirisk' ); ?></span><i class="circle">1</i></li>
		<li class=""><span><?php _e( 'Import staff', 'digirisk' ); ?></span><i class="circle">2</i></li>
	</ul>

	<div class="wp-digi-bloc-loader">
		<h3><?php _e( 'Your society', 'digirisk' );?></h3>

		<form method="POST" class="wp-digi-form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
			<input type="hidden" name="action" value="wpdigi-installer-step-1" />
			<?php wp_nonce_field( 'ajax_installer_step_1' ); ?>

			<ul class="gridwrapper2">
				<li class="form-element">
					<label><?php _e( 'Society name', 'digirisk' ); ?><input type="text" name="groupment[title]" /></label>
					<button class="wp-digi-bton-fourth btn-more-option"><?php _e( 'More options', 'digirisk'); ?></button>
				</li>
			</ul>

			<div class="form-more-option hidden">
				<ul class="gridwrapper2">
					<li class="form-element"><label><?php _e( 'Address', 'digirisk' ); ?> <input type="text" name="address[address]" /></label></li>
					<li class="form-element">
						<label><?php _e( 'Owner', 'digirisk' ); ?> <input type="text" data-target="owner_id" placeholder="<?php _e( 'Write name to search...', 'digirisk' ); ?>" data-filter="" class="wpdigi-auto-complete-user" value="<?php echo !empty( $user ) ? $user->login : ''; ?>" /></label>
						<input type="hidden" name="groupment[user_info][owner_id]" />
					</li>
					<li class="form-element"><label><?php _e( 'Additional address', 'digirisk' ); ?> <input type="text" name="address[additional_address]" /></label></li>
					<li class="form-element"><label><?php _e( 'Created date', 'digirisk' ); ?> <input type="text" class="wpdigi_date" name="groupment[date]" value="<?php echo current_time( 'd/m/Y', 0 ); ?>" /></label></li>
					<li class="form-element"><label><?php _e( 'Postcode', 'digirisk' ); ?> <input type="text" name="address[postcode]" /></label></li>
					<li class="form-element"><label><?php _e( 'SIREN', 'digirisk' ); ?> <input type="text" name="groupment[identity][siren]" /></label></li>
					<li class="form-element"><label><?php _e( 'Town', 'digirisk' ); ?> <input type="text" name="address[town]" /></label></li>
					<li class="form-element"><label><?php _e( 'SIRET', 'digirisk' ); ?> <input type="text" name="groupment[identity][siret]" /></label></li>
					<li class="form-element"><label><?php _e( 'Phone', 'digirisk' ); ?> <input type="text" name="groupment[contact][phone][]" /></label></li>
				</ul>

				<div class="form-element block"><label><?php _e( 'Description', 'digirisk' ); ?><textarea name="groupment[content]"></textarea></label></div>
			</div>

			<input type="button" class="float right wp-digi-bton-fourth" value="<?php _e( 'Save', 'digirisk' ); ?>" />
		</form>
	</div>

	<?php \digi\user_action::g()->display_page_staff( true ); ?>

</div>
