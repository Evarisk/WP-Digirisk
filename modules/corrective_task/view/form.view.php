<?php
/**
 * Le formulaire pour ajouter une tâche corrective.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php do_shortcode( '[task id="' . $task->id . '"]' ); ?>

<a href="<?php echo esc_attr( admin_url( 'admin.php?page=wpeomtm-dashboard&term=' . $task->id ) ); ?>"><?php esc_html_e( 'Aller vers la tâche', 'digirisk' ); ?></a>

<div class="button green margin uppercase strong float right"><span><?php esc_html_e( 'OK', 'digirisk' ); ?></span></div>
