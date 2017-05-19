<?php
/**
 * La vue contenant le tableau d'édition des utilisateurs ainsi que le domaine de l'email.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package user_dashboard
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="digirisk-wrap user-dashboard">
	<h1><?php esc_html_e( 'Les utilisateurs de Digirisk' , 'digirisk' ); ?></h1>

	<div class="form email-domain">
		<div class="form-element active">
			<input type="hidden" name="action" value="save_domain_mail" />
			<?php wp_nonce_field( 'save_domain_mail' ); ?>
			<input class="input-domain-mail" name="domain_mail" type="text" value="<?php echo esc_attr( get_option( 'digirisk_domain_mail', 'demo.com' ) ); ?>" />
			<label class="tooltip red" aria-label="<?php echo esc_attr( 'Domaine de l\'email invalide.', 'digirisk' ); ?>"><?php esc_html_e( 'Domaine de l\'email', 'digirisk' ); ?></label>
			<span class="bar"></span>
		</div>
		<span data-parent="form" data-namespace="digirisk" data-module="userDashboard" data-before-method="checkDomainEmailValid" class="w40 action-input float right button green"><i class="fa fa-floppy-o" aria-hidden="true"></i></span>
	</div>

	<!-- Liste les utilisateurs -->
	<table class="table users">
		<?php	User_Dashboard_Class::g()->display_list_user(); ?>
	</table>

	<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-simple-risk-evaluation' ) ); ?>" type="button" class="float right button blue uppercase strong">
		<span><?php esc_html_e( 'Aller sur l\'application', 'digirisk' ); ?></span>
	</a>
</div>
