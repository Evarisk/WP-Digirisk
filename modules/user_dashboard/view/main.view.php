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

<div class="digirisk-wrap user-dashboard wpeo-wrap wrap">
	<input class="input-domain-mail" name="domain_mail" type="hidden" value="<?php echo esc_attr( get_option( 'digirisk_domain_mail', 'demo.com' ) ); ?>" />

	<!-- Liste les utilisateurs -->
	<div class="wpeo-table table-flex users">
		<?php User_Dashboard_Class::g()->display_list_user(); ?>
	</div>

	<?php if ( ! empty( $from_install ) ) : ?>
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk' ) ); ?>" type="button" class="wpeo-button button-main alignright margin">
			<span><?php esc_html_e( 'Aller sur l\'application', 'digirisk' ); ?></span>
		</a>
	<?php endif; ?>
</div>
