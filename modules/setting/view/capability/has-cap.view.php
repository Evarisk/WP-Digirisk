<?php
/**
 * Affiches les rôles qui ont les capacités "manage_digirisk".
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $role_subscriber->capabilities['manage_digirisk'] ) ) :
	?>
	<p class="red"><?php esc_html_e( 'La capacité "manage_digirisk" est appliqué sur tous les utilisateurs dont le rôle est abonnés. Vous devez supprimer la capacité "manage_digirisk" sur celui-ci pour pouvoir gérer manuellement par utilisateur ce droit.', 'digirisk' ); ?></p>
	<?php
endif;
