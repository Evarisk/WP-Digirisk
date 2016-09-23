<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap user-dashboard">
	<h3><?php _e( 'Les utilisateurs de Digirisk' , 'digirisk' ); ?></h3>
	<!-- Liste les utilisateurs -->
	<form method="POST" id="wp-digi-form-add-staff" class="wp-digi-form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
		<?php require( USERS_VIEW . '/page-user/list.view.php' ); ?>
	</form>

	<?php do_shortcode( '[digi-user-detail id=2]' ); ?>
</div>
