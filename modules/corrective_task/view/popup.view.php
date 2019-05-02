<?php
/**
 * La popup contenant les tâches correctives d'un risque.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.2.7
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-modal wpeo-wrap corrective-task">
	<div class="container">

		<div class="header">
			<h2 class="title"><?php esc_html_e( 'Édition des tâches correctives', 'digirisk' ); ?></h2>
			<i class="close fas fa-times"></i>
		</div>

		<div class="content" style="overflow-y: scroll; height: 600px;">
		</div>
	</div>
</div>
