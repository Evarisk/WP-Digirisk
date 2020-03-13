<?php
/**
 * Affichage principale de la page "Causeries".
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( user_can( get_current_user_id(), 'manage_preventionplan' ) ):
	?>
	<li>
		<a class="wpeo-button button-main button-square-30 button-rounded page-title-action wpeo-tooltip-event"
			href="<?php echo esc_attr( admin_url( 'admin-post.php?action=start_prevention' ) ); ?>"
			aria-label="<?php esc_html_e( 'Commencer un plan de prévention', 'digirisk' ); ?>"
			data-direction="bottom">
			<i class="fas fa-plus"></i>
		</a>
	</li>
	<?php
endif;
