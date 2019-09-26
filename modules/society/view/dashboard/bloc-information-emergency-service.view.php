<?php
/**
 * Données concernant la partie service d'urgence de la société
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.3.3
 * @version 7.3.3
 * @copyright 2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<div class="wpeo-notice bloc-information-society wpeo-tooltip-event"
	data-element="emergency-service-edit"
	data-action="display_edit_view"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_edit_view' ) ); ?>"
	data-id="<?php echo esc_attr( $element->data[ 'id' ] ); ?>"
	<?php if( $edit): ?>
		data-edit="true"
		style="border: solid blue 1px;"
		aria-label="<?php esc_html_e( 'Sauvegarder pour fermer', 'digirisk' ); ?>"
	<?php else: ?>
		data-edit="false"
		aria-label="<?php esc_html_e( 'Cliquer pour ouvrir', 'digirisk' ); ?>"
	<?php endif; ?>>
	<div class="notice-content" style="display: grid;">
		<div>
			<input type="hidden" name="indicator-id" value="indicator-emergency-service">
			<input type="hidden" name="indicator-nbr-total" value="<?php echo esc_attr( $element->data[ 'indicator' ][ 'emergency-service' ][ 'nbr_total' ] ); ?>">
			<input type="hidden" name="indicator-nbr-valid" value="<?php echo esc_attr( $element->data[ 'indicator' ][ 'emergency-service' ][ 'nbr_valid' ] ); ?>">
			<div class="" style="float:left">
				<div class="notice-title-custom">
					<?php esc_html_e( 'Service d\'urgence et Consigne de Sécurité', 'digirisk' ); ?>
				</div>
				<div class="notice-subtitle">
					<?php esc_html_e( 'Données complémentaires à la société, possiblement utilisé dans la réalisation de Causerie/ Plan de prévention', 'digirisk' ); ?>
				</div>
			</div>

			<div class="bloc-indicator wpeo-tooltip-event" aria-label="<?php echo esc_attr( $element->data[ 'indicator' ][ 'emergency-service' ][ 'info' ] ); ?>" data-percent="<?php echo esc_attr( $element->data[ 'indicator' ][ 'emergency-service' ][ 'percent' ] ); ?>" style="float:right; height:100px;width:100px">
				<canvas id="indicator-emergency-service" class="wpeo-modal-event alignright" style="border : none">
				</canvas>
			</div>
		</div>

		<div class="bloc-content" style="display : block">
			<?php if( $edit ):
				\eoxia\View_Util::exec( 'digirisk', 'society', 'dashboard/edit/bloc-information-emergency-service', array(
					'element' => $element,
					'address' => $address,
					'legal_display' => $legal_display
				) );
			endif; ?>
		</div>
	</div>
</div>
