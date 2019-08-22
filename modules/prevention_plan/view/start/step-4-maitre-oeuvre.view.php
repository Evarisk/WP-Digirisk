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

<?php // echo '<pre>'; print_r( $user ); echo '</pre>'; exit; ?>
<section class="wpeo-gridlayout padding grid-4" style="margin-bottom: 10px;">
	<input type='hidden' name="prevention_id" value="<?php echo esc_attr( $prevention->data['id'] ); ?>">
	<div class="wpeo-form">
		<div class="form-element element-maitre-oeuvre">
			<input type="hidden" name="prevention_id" value="<?php echo esc_attr( $prevention->data[ 'id' ] ); ?>">
			<span class="form-label"><?php esc_html_e( 'Nom', 'task-manager' ); ?></span>
			<?php if( ! empty( $user ) && isset( $user->first_name ) ): ?>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
					<input type="text" class="form-field" name="maitre-oeuvre-name" value="<?php echo esc_attr( $user->first_name ); ?>">
				</label>
			<?php else: ?>
				<?php $eo_search->display( 'maitre_oeuvre' ); ?>
			<?php endif; ?>
		</div>
	</div>

	<div class="wpeo-form">
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Prénom', 'task-manager' ); ?></span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
					<?php if( ! empty( $user ) && isset( $user->last_name ) ): ?>
						<input type="text" class="form-field" name="maitre-oeuvre-lastname" value="<?php echo esc_attr( $user->last_name ); ?>">
					<?php else: ?>
						<input type="text" class="form-field" name="maitre-oeuvre-lastname" value="">
					<?php endif; ?>
				</label>
		</div>
	</div>

	<div class="wpeo-form">
		<div class="form-element element-phone">
			<span class="form-label"><?php esc_html_e( 'Portable', 'task-manager' ); ?></span>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-mobile-alt"></i></span>
				<input type="text" class="form-field element-phone-input" name="maitre-oeuvre-phone" value="" data-verif="false">
			</label>
		</div>
	</div>
<section class="wpeo-gridlayout padding grid-2" style="margin-bottom: 10px;">
	<div class="wpeo-form">
		<div class="form-element signature-info-element">
			<span class="form-label"><?php esc_html_e( 'Signature', 'task-manager' ); ?></span>
			<?php if ( empty( $prevention->data['maitre_oeuvre']['signature_id'] ) ) : ?>
				<input type="hidden" name="maitre-oeuvre" value="ko">
				<div class="signature w50 padding">
					<div class="wpeo-button button-blue wpeo-modal-event"
						data-parent="form-element"
						data-target="modal-signature">
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
	<div class="">
	</div>
	</section>
</section>
