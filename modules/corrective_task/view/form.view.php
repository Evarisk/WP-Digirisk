<?php
namespace digi;
if ( !defined( 'ABSPATH' ) ) exit;
global $point_controller;

?>
	<div class="wpeo-project-wrap">
		<div class="wpeo-project-task">
			<?php	echo $point_controller->callback_task_content( '', $task );	?>
		</div>
	</div>
<?php
