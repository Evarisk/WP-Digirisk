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
} ?>

<ul>
	<li><?php esc_html_e( sprintf( 'Cette causerie à été réalisée %d fois', $main_causerie->number_time_realized ), 'digirisk' ); ?></li>
	<li><?php esc_html_e( sprintf( '%d personnes y ont déjà participés', $main_causerie->number_participants ), 'digirisk' ); ?></li>

	<?php if ( $main_causerie->number_time_realized > 0 ) : ?>
		<li>
			<span><?php esc_html_e( 'Réalisée pour la dernière fois le', 'digirisk' ); ?></span>
			<span><?php echo esc_html( $main_causerie->last_date_realized['date_input']['fr_FR']['date'] ); ?></span>
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
				<input type="text"
							data-field="former_id"
							data-type="user"
							placeholder=""
							class="digi-search"
							value="" />
				<input type="hidden" name="former_id" value="" />
				<input type="hidden" name="causerie_id" value="<?php echo esc_attr( $final_causerie->id ); ?>" />
				<input type="hidden" name="is_former" value="true" />
			</td>

			<?php if ( empty( $final_causerie->former['signature_id'] ) ) : ?>
				<td class="signature w50 padding tooltip red signature-tooltip" aria-label="<?php esc_attr_e( 'La signature du formateur est obligatoire', 'digirisk' ); ?>">
					<div class="button blue disabled wpeo-modal-event tooltip hover" aria-label="<?php esc_attr_e( 'Veuillez sélectionner un formateur avant de signer', 'digirisk' ); ?>"
						data-parent="signature"
						data-target="modal-signature">
						<span><?php esc_html_e( 'Signé', 'digirisk' ); ?></span>
					</div>
					<?php
					\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/modal', array(
						'action' => 'causerie_save_signature',
					) );
					?>
				</td>
			<?php else : ?>
				<td><img class="signature" src="<?php echo esc_attr( wp_get_attachment_url( $final_causerie->former['signature_id'] ) ); ?>"</td>
			<?php endif; ?>
		</tr>
	</tbody>
</table>

<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie' ) ); ?>" class="button grey">
	<span><?php esc_html_e( 'Retour', 'digirisk' ); ?></span>
</a>

<div class="button blue action-input float right disabled"
	data-parent="ajax-content"
	data-action="next_step_causerie"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_causerie' ) ); ?>"
	data-id="<?php echo esc_attr( $final_causerie->id ); ?>"
	data-namespace="digirisk"
	data-module="causerie"
	data-before-method="checkAllData">
	<span><?php esc_html_e( 'Lecture de la causerie', 'digirisk' ); ?></span>
</div>
