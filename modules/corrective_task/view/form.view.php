<?php
/**
 * Le formulaire pour ajouter une tâche corrective.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package duer
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

global $point_controller; ?>

<div class="wpeo-project-wrap">
	<div class="wpeo-project-task" data-id="<?php echo esc_attr( $task->id ); ?>">
		<?php	echo $point_controller->callback_task_content( '', $task );	?>
	</div>
</div>

<div class="button green margin uppercase strong float right"><span>OK</span></div>
