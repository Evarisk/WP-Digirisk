<?php
/**
 * Evaluation d'une causerie: étape 1, permet d'affecter le formateur et d'éditer sa signature.
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

<ul class="causerie-stats wpeo-gridlayout grid-4">
	<li><?php esc_html_e( sprintf( 'Cette causerie à été réalisée %d fois', $main_causerie->data['number_time_realized'] ), 'digirisk' ); ?></li>
	<li><?php esc_html_e( sprintf( '%d personnes y ont déjà participés', $main_causerie->data['number_participants'] ), 'digirisk' ); ?></li>

	<?php if ( $main_causerie->data['number_time_realized'] > 0 ) : ?>
		<li>
			<span><?php esc_html_e( 'Réalisée pour la dernière fois le', 'digirisk' ); ?></span>
			<span><?php echo esc_html( $main_causerie->data['last_date_realized']['rendered']['date'] ); ?></span>
		</li>
	<?php endif; ?>
</ul>

<h2><?php esc_html_e( 'Formateur', 'digirisk' ); ?></h2>

<table class="table causerie">
	<thead>
		<tr>
			<th class="padding"><?php esc_html_e( 'Formateur', 'digirisk' ); ?>.</th>
			<th class="w50 padding"><?php esc_html_e( 'Signature', 'digirisk' ); ?>.</th>
		</tr>
	</thead>

	<tbody>
		<tr class="item">
			<td class="padding tooltip red former-tooltip" aria-label="<?php esc_attr_e( 'Veuillez renseigner le formateur', 'digirisk' ); ?>">
				<?php $eo_search->display( 'causerie_former' ); ?>
				<input type="hidden" name="causerie_id" value="<?php echo esc_attr( $final_causerie->data['id'] ); ?>" />
				<input type="hidden" name="is_former" value="true" />
			</td>

			<?php if ( empty( $final_causerie->data['former']['signature_id'] ) ) : ?>
				<td class="signature w50 padding">
					<div class="wpeo-button button-blue wpeo-modal-event <?php echo empty( $final_causerie->data['former']['user_id'] ) ? 'button-disable' : ''; ?>"
						data-title="<?php echo empty( $user ) ? '' : 'Signature de l\'utilisateur: ' . $user->data->display_name; ?>"
						data-parent="signature"
						data-target="modal-signature">
						<span><?php esc_html_e( 'Signer', 'digirisk' ); ?></span>
					</div>
					<?php
					\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/modal', array(
						'action' => 'causerie_save_signature',
					) );
					?>
				</td>
			<?php else : ?>
				<td><img class="signature" src="<?php echo esc_attr( wp_get_attachment_url( $final_causerie->data['former']['signature_id'] ) ); ?>"</td>
			<?php endif; ?>
		</tr>
	</tbody>
</table>

<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie' ) ); ?>" class="wpeo-button button-grey">
	<span><?php esc_html_e( 'Retour', 'digirisk' ); ?></span>
</a>

<div class="wpeo-button button-blue action-input float right <?php echo ( empty( $final_causerie->data['former']['user_id'] ) && empty( $final_causerie->data['former']['signature_id'] ) ) ? 'button-disable' : ''; ?>"
	data-parent="ajax-content"
	data-action="next_step_causerie"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_causerie' ) ); ?>"
	data-id="<?php echo esc_attr( $final_causerie->data['id'] ); ?>"
	data-namespace="digirisk"
	data-module="causerie"
	data-before-method="checkAllData">
	<span><?php esc_html_e( 'Lecture de la causerie', 'digirisk' ); ?></span>
</div>
