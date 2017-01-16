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
	<h3><?php esc_html_e( 'Les utilisateurs de Digirisk' , 'digirisk' ); ?></h3>

	<ul class="form">
		<li class="form-element active">
			<input class="input-domain-mail" type="text" value="<?php echo esc_attr( get_option( 'digirisk_domain_mail', 'demo.com' ) ); ?>" />
			<label><?php esc_html_e( 'Domaine de l\'email', 'digirisk' ); ?></label>
			<span class="bar"></span>
		</li>
	</ul>

	<a href="#" data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_domain_mail' ) ); ?>" class="button green" aria-hidden="true"><?php esc_html_e( 'Sauvegarder', 'digirisk' ); ?></a>

	<!-- Liste les utilisateurs -->
	<table class="table users">
		<?php	User_Dashboard_Class::g()->display_list_user(); ?>
	</table>
</div>
