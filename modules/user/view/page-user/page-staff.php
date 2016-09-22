<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wpdigi-staff <?php echo empty( $hidden ) ? 'wrap' : 'hidden'; ?>">
	<h3><?php _e( 'Add a Digirisk user' , 'digirisk' ); ?></h3>

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
		<?php require( USERS_VIEW . '/page-user/list.view.php' ); ?>
	</form>



	<a href="<?php echo admin_url( 'admin.php?page=digirisk-simple-risk-evaluation' ); ?>" class="float right <?php echo empty( $hidden ) ? 'hidden' : 'wp-digi-bton-fourth'; ?>"><?php _e( 'Save', 'digirisk' ); ?></a>
</div>
