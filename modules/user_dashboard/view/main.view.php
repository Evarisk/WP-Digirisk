<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="digirisk-wrap user-dashboard">
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
	<table class="table">
		<?php
			User_Dashboard_Class::g()->display_list_user();
			View_Util::exec( 'user_dashboard', 'item-edit', array( 'user' => $user ) );
		?>
	</table>
</div>
