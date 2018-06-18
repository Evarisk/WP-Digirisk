<?php
/**
 * La vue contenant le tableau d'édition des utilisateurs ainsi que le domaine de l'email.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.3
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="digirisk-wrap user-dashboard">
	<h1><?php esc_html_e( 'Les utilisateurs de Digirisk', 'digirisk' ); ?></h1>

	<input class="input-domain-mail" name="domain_mail" type="hidden" value="<?php echo esc_attr( get_option( 'digirisk_domain_mail', 'demo.com' ) ); ?>" />

	<!-- Liste les utilisateurs -->
	<table class="table users">
		<?php	User_Dashboard_Class::g()->display_list_user(); ?>
	</table>

	<?php if ( ! empty( $_GET['from_install'] ) ) : // WPCS: CSRF ok. ?>
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-simple-risk-evaluation' ) ); ?>" type="button" class="float right button blue uppercase strong">
			<span><?php esc_html_e( 'Aller sur l\'application', 'digirisk' ); ?></span>
		</a>
	<?php endif; ?>
</div>
