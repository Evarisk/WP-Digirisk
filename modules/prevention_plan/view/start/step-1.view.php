<?php
/**
 * Premiere page dans la création d'un plan de prévention
 * Ajoute un formateur avec sa signature
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

<ul class="prevention-stats wpeo-gridlayout grid-4">
	Some stats here
</ul>

<div class="information-maitre-oeuvre">

	<div class="information-maitre-oeuvre" style="background-color: #fff; padding: 1em;">
		<input type="hidden" name="user-type" value="maitre_oeuvre">
		<h2 style="text-align:center">
			<?php esc_html_e( 'Maitre d\'oeuvre', 'digirisk' ); ?> -
			<i><?php echo esc_attr( $society->data[ 'title' ] ); ?></i>
		</h2>
		<?php Prevention_Class::g()->display_maitre_oeuvre( array(), $prevention->data[ 'id' ] ); ?>
	</div>

<?php if( isset( $prevention->data[ 'maitre_oeuvre' ][ 'data' ] ) && $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->first_name != "" && $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->last_name != ""  && $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->phone && $prevention->data[ 'maitre_oeuvre' ][ 'signature_id' ] != 0 ): ?>
	<div class="wpeo-button button-blue action-input float right prevention-start"
<?php else: ?>
	<div class="wpeo-button button-blue action-input float right prevention-start button-disable"
<?php endif; ?>
		data-parent="ajax-content"
		data-action="next_step_prevention"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_prevention' ) ); ?>"
		data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>"
		style="float:right">
		<span><?php esc_html_e( 'Débuter', 'digirisk' ); ?></span>
	</div>
</div>


<?php /* ?>

<h2><?php esc_html_e( 'Formateur', 'digirisk' ); ?></h2>
<table class="table prevention" style="margin-bottom : 10px">
	<thead>
		<tr>
			<th class="padding"><?php esc_html_e( 'Formateur', 'digirisk' ); ?>.</th>
			<th class="w50 padding"><?php esc_html_e( 'Signature', 'digirisk' ); ?>.</th>
		</tr>
	</thead>

	<tbody>
		<tr class="item">
			<td class="padding tooltip red former-tooltip" aria-label="<?php esc_attr_e( 'Veuillez renseigner le formateur', 'digirisk' ); ?>" style="padding : 0.6em">
				<input type="hidden" name="prevention_id" value="<?php echo esc_attr( $prevention->data['id'] ); ?>" />
				<input type="hidden" name="is_former" value="true" />
				<?php if( $prevention->data[ 'former' ][ 'user_id' ] ): ?>
					<input type="hidden" name="former_id" value="<?php echo esc_attr( $prevention->data[ 'former' ][ 'user_id' ] ); ?>" />
				<?php endif; ?>
				<?php $eo_search->display( 'prevention_former' ); ?>
			</td>

			<?php if ( empty( $prevention->data['former']['signature_id'] ) ) : ?>
				<td class="signature w50 padding">
					<div class="wpeo-button button-blue wpeo-modal-event <?php echo empty( $prevention->data['former']['user_id'] ) ? 'button-disable' : ''; ?>"
						data-title="<?php echo empty( $user ) ? '' : 'Signature de l\'utilisateur: ' . $user->data->display_name; ?>"
						data-parent="signature"
						data-target="modal-signature">
						<span><?php esc_html_e( 'Signer', 'digirisk' ); ?></span>
					</div>
					<?php
					\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-1-signature-modal', array(
						'action' => 'prevention_save_signature',
						'parent_element' => 'item'
					) );
					?>
				</td>
			<?php else : ?>
				<td><img class="signature" src="<?php echo esc_attr( wp_get_attachment_url( $prevention->data['former']['signature_id'] ) ); ?>"</td>
			<?php endif; ?>
		</tr>
	</tbody>
</table>

<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-prevention' ) ); ?>" class="wpeo-button button-grey">
	<span><?php esc_html_e( 'Retour', 'digirisk' ); ?></span>
</a>

<div class="wpeo-button button-blue action-input float right <?php echo ( empty( $prevention->data['former']['user_id'] ) && empty( $prevention->data['former']['signature_id'] ) ) ? 'button-disable' : ''; ?>"
	data-parent="ajax-content"
	data-action="next_step_prevention"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_prevention' ) ); ?>"
	data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>"
	data-namespace="digirisk"
	data-module="causerie"
	data-before-method="checkAllData"
	style="float:right">
	<span><?php esc_html_e( 'Valider formateur', 'digirisk' ); ?></span>
</div>

*/ ?>
