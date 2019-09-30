<?php
/**
 * Ajoutes les boutons des méthodes d'évaluation nécéssitant une modaL.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $evaluations_method ) ) :
	foreach ( $evaluations_method as $evaluation_method ) :
		?>
		<li class="dropdown-item wpeo-tooltip-event wpeo-modal-event cotation method"
			aria-label="Méthode <?php echo esc_attr( $evaluation_method->data['name'] ); ?>"
			data-action="load_modal_method_evaluation"
			data-title="<?php esc_attr_e( 'Édition de la cotation', 'digirisk' ); ?>"
			data-class="wpeo-wrap evaluation-method modal-risk-<?php echo esc_attr( $risk_id ); ?>"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_modal_method_evaluation' ) ); ?>"
			data-id="<?php echo esc_attr( $evaluation_method->data['id'] ); ?>"
			wpeo-before-cb="digirisk/evaluationMethodEvarisk/fillVariables"
			data-risk-id="<?php echo esc_attr( $risk_id ); ?>"><i class="icon fa fa-cog"></i></li>
		<?php
	endforeach;
endif;
