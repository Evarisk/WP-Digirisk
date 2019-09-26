<?php
/**
 * Données principales de la société
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
	data-element="society-edit"
	data-action="display_edit_view"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_edit_view' ) ); ?>"
	data-id="<?php echo esc_attr( $element->data[ 'id' ] ); ?>"
	<?php if( $edit): ?>
		style="border: solid blue 1px;"
		data-edit="true"
		aria-label="<?php esc_html_e( 'Sauvegarder pour fermer', 'digirisk' ); ?>"
	<?php else: ?>
		data-edit="false"
		aria-label="<?php esc_html_e( 'Cliquer pour ouvrir', 'digirisk' ); ?>"
	<?php endif; ?>>
	<div class="notice-content" style="display: grid;">
		<div>
			<input type="hidden" name="indicator-id" value="indicator-society">
			<input type="hidden" name="indicator-nbr-total" value="<?php echo esc_attr( $element->data[ 'indicator' ][ 'society' ][ 'nbr_total' ] ); ?>">
			<input type="hidden" name="indicator-nbr-valid" value="<?php echo esc_attr( $element->data[ 'indicator' ][ 'society' ][ 'nbr_valid' ] ); ?>">
			<div class="" style="float:left">
				<div class="notice-title-custom">
					<?php esc_html_e( 'Information primaire de la société', 'digirisk' ); ?>
				</div>
				<div class="notice-subtitle">
					<?php esc_html_e( 'Données primaires de la société, indispensable pour la réalisation de Causerie/ Plan de prévention', 'digirisk' ); ?>
				</div>
				<div class="" style="margin-top:20px; margin-bottom:10px; color: rgb(36, 124, 255);; font-size : 15px">
					<span>
						<i class="fas fa-hashtag"></i><b style="color : #3d4052;">2278</b>
					</span>
					<span class="wpeo-tooltip-event" aria-label="Dernière modification" style="margin-left:20px">
						<i class="fas fa-clock"></i>
						<b style="color : #3d4052;">
							 26/10/2017				</b>
					</span>
					<span class="wpeo-tooltip-event" aria-label="Nom de l'entreprise" style="margin-left:20px">
						<i class="fas fa-building"></i><b style="color : #3d4052;"> COPAC Beauchamp</b>
					</span>
				</div>
			</div>

			<div class="bloc-indicator wpeo-tooltip-event" aria-label="<?php echo esc_attr( $element->data[ 'indicator' ][ 'society' ][ 'info' ] ); ?>" data-percent="<?php echo esc_attr( $element->data[ 'indicator' ][ 'society' ][ 'percent' ] ); ?>" style="float:right; height:100px;width:100px">
				<canvas id="indicator-society" class="wpeo-modal-event alignright" style="border : none">
				</canvas>
			</div>
		</div>

		<div class="bloc-content" style="display : block">
			<?php if( $edit ):
				\eoxia\View_Util::exec( 'digirisk', 'society', 'dashboard/edit/bloc-information-society', array(
					'element' => $element,
					'address' => $address,
				) );
			endif; ?>
		</div>
	</div>
</div>
