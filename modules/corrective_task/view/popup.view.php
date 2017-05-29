<?php
/**
 * La popup contenant les tâches correctives d'un risque.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.7.0
 * @copyright 2015-2017 Evarisk
 * @package duer
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="popup corrective-task">
	<div class="container">

		<div class="header">
			<h2 class="title"><?php esc_html_e( 'Édition des tâches correctives', 'digirisk' ); ?></h2>
			<i class="close fa fa-times"></i>
		</div>

		<div class="content" style="overflow-y: scroll; height: 600px;">
		</div>
	</div>
</div>
