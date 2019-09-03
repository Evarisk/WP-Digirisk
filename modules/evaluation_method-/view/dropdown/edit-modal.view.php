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

<input type="hidden" name="evaluation_method_id" value="<?php echo esc_attr( $evaluation_method_id ); ?>" />
<textarea style="display: none;" name="evaluation_variables"><?php echo ! empty( $risk->data['evaluation']->data ) ? wp_json_encode( $risk->data['evaluation']->data['variables'], JSON_FORCE_OBJECT ) : '{}'; ?></textarea>

<div class="cotation wpeo-tooltip-event wpeo-modal-event"
	aria-label="Modifier la cotation"
	data-action="load_modal_method_evaluation"
	data-class="evaluation-method wpeo-wrap modal-risk-<?php echo esc_attr( $risk->data['id'] ); ?>"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_modal_method_evaluation' ) ); ?>"
	data-id="<?php echo esc_attr( $evaluation_method->data['id'] ); ?>"
	data-risk-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
	data-scale="<?php echo ! empty( $risk->data['evaluation'] ) ? esc_attr( $risk->data['evaluation']->data['scale'] ) : 0; ?>"
	wpeo-before-cb="digirisk/evaluationMethodEvarisk/fillVariables">
	<span><?php echo esc_html( $risk->data['current_equivalence'] ); ?></span>
</div>
