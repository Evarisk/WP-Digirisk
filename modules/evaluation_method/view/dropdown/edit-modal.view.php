<?php
/**
 * Template permettant d'ouvrir la modal pour éditer la cotation d'un risque.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="dropdown-item wpeo-tooltip-event wpeo-modal-event"
	aria-label="Méthode <?php echo esc_attr( $evaluation_method->data['name'] ); ?>"
	data-action="load_modal_method_evaluation"
	data-class="evaluation-method modal-risk-<?php echo esc_attr( $risk_id ); ?>"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_modal_method_evaluation' ) ); ?>"
	data-id="<?php echo esc_attr( $evaluation_method->data['id'] ); ?>"
	data-risk-id="<?php echo esc_attr( $risk_id ); ?>"><i class="icon fa fa-cog"></i></div>
