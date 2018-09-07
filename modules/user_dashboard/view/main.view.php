<?php
/**
 * Le template principal pour la page des utilisateurs DigiRisk (digirisk-users).
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.2.3
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="digirisk-wrap user-dashboard wpeo-wrap">
	<h1><?php esc_html_e( 'Les utilisateurs de Digirisk', 'digirisk' ); ?></h1>

	<input class="input-domain-mail" name="domain_mail" type="hidden" value="<?php echo esc_attr( get_option( 'digirisk_domain_mail', 'demo.com' ) ); ?>" />

	<!-- Liste les utilisateurs -->
	<table class="table users">
		<?php User_Dashboard_Class::g()->display_list_user(); ?>
	</table>

	<?php if ( ! empty( $from_install ) ) : ?>
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-simple-risk-evaluation' ) ); ?>" type="button" class="wpeo-button button-main alignright margin">
			<span><?php esc_html_e( 'Aller sur l\'application', 'digirisk' ); ?></span>
		</a>
	<?php endif; ?>
</div>
