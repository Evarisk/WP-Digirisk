<?php
/**
 * La vue de la modal.
 *
 * La "div.wpeo-modal.modal-active" englobant le contenant de la modal est généré par le fichier modal.lib.js.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018 Eoxia
 * @package EO_Framework\Core\View
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
		<div class="modal-close"><i class="fas fa-times"></i></div>
	</div>

	<!-- Corps -->
	<div class="modal-content">{{content}}</div>

	<!-- Footer -->
	<div class="modal-footer">{{buttons}}</div>
</div>
