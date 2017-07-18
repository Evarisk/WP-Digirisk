<?php
/**
 * Le formulaire pour ajouter une tâche corrective.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.10.0
 * @copyright 2015-2017 Evarisk
 * @package corrective-task
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php do_shortcode( '[task id="' . $task->id . '"]' ); ?>

<a href="<?php echo esc_attr( admin_url( 'admin.php?page=wpeomtm-dashboard&term=' . $task->id ) ); ?>"><?php esc_html_e( 'Aller vers la tâche', 'digirisk' ); ?></a>

<div class="button green margin uppercase strong float right"><span><?php esc_html_e( 'OK', 'digirisk' ); ?></span></div>
