<?php
/**
 * Affichage d'un evaluateur
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.6.0
 * @version 7.6.0
 * @copyright 2015-2020 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="table-row evaluator-row user-<?php echo esc_attr( $evaluator['user_info']->data['id'] ); ?>">
	<input type="hidden" name="action" value="detach_evaluator" />
		<?php wp_nonce_field( 'detach_evaluator' ); ?>
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $evaluator['user_info']->data['id'] ); ?>" />
	<div class="table-cell table-50">
		<?php echo esc_attr( User_Class::g()->element_prefix . $evaluator['user_info']->data['id'] ); ?>
	</div>
	<div class="table-cell">
		<div class="avatar" style="background-color: #<?php echo esc_attr( $evaluator['user_info']->data['avatar_color'] ); ?>;"><span><?php echo esc_html( $evaluator['user_info']->data['initial'] ); ?></span></div>
			<?php echo esc_html( $evaluator['user_info']->data['displayname'] ); ?>
		</div>
		<div class="table-cell table-125"><?php echo esc_html( date( $evaluator['affectation_info']['start']['date'] ) ); ?></div>
		<div class="table-cell table-50"><?php echo esc_html( Evaluator_Class::g()->get_duration($evaluator['affectation_info']) ); ?></div>
		<div class="table-cell table-50 table-end">
			<div 	class="action-delete wpeo-button button-square-50 button-grey delete"
					data-id="<?php echo esc_attr( $element->data['id'] ); ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'detach_evaluator' ) ); ?>"
					data-action="detach_evaluator"
					data-user-id="<?php echo esc_attr( $evaluator['user_info']->data['id'] ); ?>"
					data-affectation-id="<?php echo esc_attr( $evaluator['affectation_info']['id'] ); ?>"
					data-loader="table-evaluator"
					data-message-delete="<?php echo esc_attr_e( 'Dissocier l\'évaluateur', 'digirisk' ); ?>">
					<i class="button-icon fas fa-trash"></i>
		</div>
	</div>
</div>

