<?php namespace digi;

global $point_controller;


if ( !defined( 'ABSPATH' ) ) exit;

?>
	<div class="wpeo-project-wrap">
		<div class="wpeo-project-task">
			
			<?php
			echo $point_controller->callback_task_content( '', $task );
			?>
		</div>
	</div>
<?php
