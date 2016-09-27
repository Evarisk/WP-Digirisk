<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap user-dashboard">
	<h3><?php _e( 'Les utilisateurs de Digirisk' , 'digirisk' ); ?></h3>

	<ul class="wp-digi-form no-form gridwrapper3 single-line">
		<li></li>
		<li></li>
		<li class="form-element wp-digi-bloc-loader">
			<label><?php _e( 'Domain mail', 'digirisk' ); ?>
				<input class="input-domain-mail" type="text" value="<?php echo get_option( 'digirisk_domain_mail', 'demo.com' ); ?>" />
			</label>
			<a href="#" data-nonce="<?php echo wp_create_nonce( 'save_domain_mail' ); ?>" class="wp-digi-action wp-digi-action-save-domain-mail fa fa-floppy-o" aria-hidden="true"></a>
		</li>
	</ul>

	<!-- Liste les utilisateurs -->
	<form method="POST" id="wp-digi-form-add-staff" class="wp-digi-form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
		<ul class="wp-digi-list wp-digi-table wp-digi-list-staff wp-digi-bloc-loader">
			<?php
				user_dashboard_class::g()->display_list_user();
				require( USER_DASHBOARD_VIEW . 'item-edit.view.php' );
			?>
		</ul>
	</form>

	<?php do_shortcode( '[digi-user-detail id=2]' ); ?>
</div>
