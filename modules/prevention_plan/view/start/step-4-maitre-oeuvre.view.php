<?php
/**
 * Information du maitre d'oeuvre (utilisateur wordpress) pour compléter les informations du plan de prévention
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $eo_search; ?>

<section class="wpeo-gridlayout padding grid-2 content-maitre-oeuvre" style="margin-bottom: 10px;">
	<input type='hidden' name="prevention_id" value="<?php echo esc_attr( $prevention->data['id'] ); ?>">
	<section class="wpeo-gridlayout padding grid-2 maitre-name-part" style="margin-bottom: 10px;">
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', '/start/step-4-maitre-oeuvre-name', array(
			'prevention' => $prevention
		) );
		?>
	</section>
	<section class="wpeo-gridlayout padding grid-2" style="margin-bottom: 10px;">

		<div class="wpeo-form maitre-phone-part">
			<?php
				\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', '/start/step-4-maitre-oeuvre-phone', array(
					'prevention' => $prevention
				) );
			?>
		</div>
		<div class="wpeo-form">
			<div class="form-element signature-info-element">
				<span class="form-label"><?php esc_html_e( 'Signature', 'task-manager' ); ?></span>
				<?php if ( empty( $prevention->data['maitre_oeuvre']['signature_id'] ) ): ?>
					<div class="signature w50 padding">
						<input type="hidden" name="maitre-oeuvre-signature" value="-1">
						<?php if( ! empty( $prevention->data[ 'maitre_oeuvre' ][ 'user_id' ] ) ): ?>
							<div class="wpeo-button button-blue wpeo-modal-event"
						<?php else: ?>
							<div class="wpeo-button button-blue wpeo-modal-event"
						<?php endif; ?>
							data-parent="form-element"
							data-target="modal-signature"
							data-title="<?php esc_html_e( 'Signature Maitre d\'oeuvre', 'task-manager' ); ?>">
							<span><?php esc_html_e( 'Signer', 'digirisk' ); ?></span>
						</div>
						<?php
						\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-1-signature-modal', array(
							'action' => 'prevention_save_signature_maitre_oeuvre',
							'parent_element' => 'information-maitre-oeuvre',
						) );
						?>
					</div>
				<?php else : ?>
					<input type="hidden" name="maitre-oeuvre-signature" value="ok">
					<div>
						<img class="signature" src="<?php echo esc_attr( wp_get_attachment_url( $prevention->data['maitre_oeuvre']['signature_id'] ) ); ?>">
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
</section>
