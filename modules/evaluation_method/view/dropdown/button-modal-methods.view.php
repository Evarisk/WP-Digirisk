<?php
/**
 * Ajoutes les boutons des méthodes d'évaluation nécéssitant une modaL.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<li class="dropdown-item cotation method open-popup wpeo-tooltip-event"
		aria-label="Méthode Evarisk"
		data-parent="risk-row"
		data-class="popup-evaluation"
		data-target="popup-evaluation"><i class="icon fa fa-cog"></i></li>
