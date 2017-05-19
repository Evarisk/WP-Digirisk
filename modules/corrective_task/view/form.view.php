<?php
/**
 * Le formulaire pour ajouter une tâche corrective.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package corrective-task
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php do_shortcode( '[task id="' . $task->id . '"]' ); ?>

<div class="button green margin uppercase strong float right"><span>OK</span></div>
