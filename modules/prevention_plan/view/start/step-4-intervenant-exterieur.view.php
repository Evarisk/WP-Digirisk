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
<section class="wpeo-gridlayout padding grid-3" style="margin-bottom: 10px;">
	<input type='hidden' name="prevention_id" value="<?php echo esc_attr( $prevention->data['id'] ); ?>">
	<div class="wpeo-form">
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Nom', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
				<input type="text" name="intervenant-lastname" class="form-field" value="<?php echo esc_attr( $prevention->data[ 'intervenant_exterieur' ][ 'lastname' ] ); ?>">
			</label>
		</div>
	</div>

	<div class="wpeo-form">
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Prénom', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
				<input type="text" name="intervenant-name" class="form-field" value="<?php echo esc_attr( $prevention->data[ 'intervenant_exterieur' ][ 'firstname' ] ); ?>">
			</label>
		</div>
	</div>

	<div class="wpeo-form">
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Email', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
				<input type="text" name="intervenant-email" class="form-field" value="<?php echo esc_attr( $prevention->data[ 'intervenant_exterieur' ][ 'email' ] ); ?>">
			</label>
		</div>
	</div>

	<div class="wpeo-form">
		<section class="wpeo-gridlayout padding grid-2  digi-phone-user" style="margin-bottom: 10px;">
			<div class="form-element">
				<span class="form-label"><?php esc_html_e( 'Code', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<?php
					\eoxia\View_Util::exec( 'digirisk', 'user', 'user-profile-list-calling-code', array(
						'local' => get_locale(),
						'width' => 'none',
						'name' => 'intervenant-phone-callingcode'
					) );
					?>
				</label>
			</div>

			<div class="form-element element-phone">
				<span class="form-label"><?php esc_html_e( 'Portable', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-mobile-alt"></i></span>
					<input type="text" class="form-field element-phone-input" name="intervenant-phone" value="<?php echo esc_attr( $prevention->data[ 'intervenant_exterieur' ][ 'phone_nbr' ] ); ?>" style="width: auto;">
				</label>
			</div>
		</section>
	</div>

	<div class="wpeo-form">
		<div class="form-element signature-info-element">
			<span class="form-label"><?php esc_html_e( 'Signature', 'digirisk' ); ?></span>
			<?php if ( empty( $prevention->data['intervenant_exterieur']['signature_id'] ) ) : ?>
				<div class="signature w50 padding">
					<input type="hidden" name="intervenant-exterieur-signature" value="-1">
					<div class="wpeo-button button-blue wpeo-modal-event"
						data-parent="form-element"
						data-target="modal-signature"
						data-title="<?php esc_html_e( 'Signature Intervenant exterieur', 'task-manager' ); ?>">
						<span><?php esc_html_e( 'Signer', 'digirisk' ); ?></span>
					</div>
					<?php
					\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-1-signature-modal', array(
						'action' => 'prevention_save_signature_maitre_oeuvre',
						'parent_element' => 'information-intervenant-exterieur',
					) );
					?>
				</div>
			<?php else : ?>
				<input type="hidden" name="intervenant-exterieur-signature" value="ok">
				<div>
					<input type="hidden" name="intervenant-signature">
					<img class="signature" src="<?php echo esc_attr( wp_get_attachment_url( $prevention->data['intervenant_exterieur']['signature_id'] ) ); ?>">
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
