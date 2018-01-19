<?php
/**
 * La vue de la modal.
 *
 * La "div.wpeo-modal.modal-active" englobant le contenant de la modal est généré par le fichier modal.lib.js.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2017 Evarisk
 * @package EO_Framework
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<!-- Structure -->
<div class="modal-container">

	<!-- Entête -->
	<div class="modal-header">
		<h2 class="modal-title">{{title}}</h2>
		<i class="modal-close fa fa-times"></i>
	</div>

	<!-- Corps -->
	<div class="modal-content">{{content}}</div>

	<!-- Footer -->
	<div class="modal-footer">{{buttons}}</div>
</div>
