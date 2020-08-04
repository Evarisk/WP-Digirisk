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

<div class="table-row evaluator-row user-<?php echo esc_attr( $evaluator->data['id'] ); ?>">
<input type="hidden" name="action" value="detach_evaluator" />
	<?php wp_nonce_field( 'detach_evaluator' ); ?>
	<div class="table-cell table-50">
<?php echo esc_attr( User_Class::g()->element_prefix . $evaluator->data['id'] ); ?>
	</div>
	<div class="table-cell">
		<div class="avatar" style="background-color: #<?php echo esc_attr( $evaluator->data['avatar_color'] ); ?>;"><span><?php echo esc_html( $evaluator->data['initial'] ); ?></span></div>
		<?php echo esc_html( $evaluator->data['displayname'] ); ?>
	</div>
	<div class="table-cell table-125"><?php echo esc_html( date( $evaluator->data['affectation_date'] ) ); ?></div>
	<div class="table-cell table-50"><?php echo esc_html(  $evaluator->data['affectation_duration']  ); ?></div>
	<div class="table-cell table-50 table-end">
		<div class="action wpeo-gridlayout grid-gap-0 grid-1">
			<!-- Edition -->

			<!-- Suppression -->
			<div 	class="action-delete wpeo-button button-square-50 button-grey delete"
					data-id="<?php echo esc_attr( $evaluator->data['id'] ); ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'detach_evaluator' ) ); ?>"
					data-action="detach_evaluator"
					data-user-id="<?php echo esc_attr( $evaluator->data['id'] ); ?>"
					data-loader="table-evaluator"
					data-message-delete="<?php echo esc_attr_e( 'Dissocier l\'évaluateur', 'digirisk' ); ?>">

					<i class="button-icon fas fa-trash"></i></div>
		</div>
	</div>
</div>

