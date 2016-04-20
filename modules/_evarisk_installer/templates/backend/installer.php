<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wpdigi-installer">
	<h2><?php _e( 'Digirisk', 'wpdigi-i18n' ); ?></h2>

	<ul class="step">
		<li class="active"><span><?php _e( 'Your informations', 'wpdigi-i18n' ); ?></span><i class="circle">1</i></li>
		<li class=""><span><?php _e( 'Import staff', 'wpdigi-i18n' ); ?></span><i class="circle">2</i></li>
	</ul>

	<div class="wp-digi-bloc-loader">
		<h3><?php _e( 'Your society', 'wpdigi-i18n' );?></h3>

		<form method="POST" class="wp-digi-form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
			<input type="hidden" name="action" value="wpdigi-installer-step-1" />
			<?php wp_nonce_field( 'ajax_installer_step_1' ); ?>

			<ul class="gridwrapper2">
				<li class="form-element"><label><?php _e( 'Society name', 'wpdigi-i18n' ); ?><input type="text" name="groupement[title]" /></label></li>
				<li class="form-element"><label><?php _e( 'Address', 'wpdigi-i18n' ); ?> <input type="text" name="address[address]" /></label></li>
				<li class="form-element"><label><?php _e( 'Owner', 'wpdigi-i18n' ); ?> <input type="text" name="groupement[option][user_info][owner_id]" /></label></li>
				<li class="form-element"><label><?php _e( 'Additional address', 'wpdigi-i18n' ); ?> <input type="text" name="address[additional_address]" /></label></li>
				<li class="form-element"><label><?php _e( 'Created date', 'wpdigi-i18n' ); ?> <input type="text" class="wpdigi_date" name="groupement[date]" value="<?php echo date( 'd/m/Y' ); ?>" /></label></li>
				<li class="form-element"><label><?php _e( 'Postcode', 'wpdigi-i18n' ); ?> <input type="text" name="address[postcode]" /></label></li>
				<li class="form-element"><label><?php _e( 'SIREN', 'wpdigi-i18n' ); ?> <input type="text" name="groupement[option][identity][siren]" /></label></li>
				<li class="form-element"><label><?php _e( 'Town', 'wpdigi-i18n' ); ?> <input type="text" name="address[town]" /></label></li>
				<li class="form-element"><label><?php _e( 'SIRET', 'wpdigi-i18n' ); ?> <input type="text" name="groupement[option][identity][siret]" /></label></li>
				<li class="form-element"><label><?php _e( 'Phone', 'wpdigi-i18n' ); ?> <input type="text" name="groupement[option][contact][phone]" /></label></li>
			</ul>

			<div class="form-element block"><label><?php _e( 'Description', 'wpdigi-i18n' ); ?><textarea name="groupement[content]"></textarea></label></div>

			<input type="button" class="float right wp-digi-bton-fourth" value="<?php _e( 'Save', 'wpdigi-i18n' ); ?>" />
		</form>
	</div>

	<?php $wpdigi_user_ctr->display_page_staff( true ); ?>

</div>
