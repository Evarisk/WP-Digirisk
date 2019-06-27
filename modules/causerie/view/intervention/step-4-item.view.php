<?php
/**
 * Affiches la liste des participants de la causerie.
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

<tr class="item">
	<td class="padding tooltip red former-tooltip" aria-label="<?php esc_attr_e( 'Veuillez renseigner le participant', 'digirisk' ); ?>">
		<div class="avatar" style="background-color: #<?php echo esc_attr( $participant['rendered']->data['avatar_color'] ); ?>;"><span><?php echo esc_html( $participant['rendered']->data['initial'] ); ?></span></div>
		<span class="participant"><?php echo esc_html( $participant['rendered']->data['displayname'] ); ?></span>
		<input type="hidden" name="participant_id" value="<?php echo esc_attr( $participant['user_id'] ); ?>" />
		<input type="hidden" name="causerie_id" value="<?php echo esc_attr( $final_causerie->data['id'] ); ?>" />
	</td>

	<?php if ( empty( $participant['signature_id'] ) ) : ?>
		<td class="signature w50 padding tooltip red signature-tooltip" aria-label="<?php esc_attr_e( 'La signature du participant est obligatoire', 'digirisk' ); ?>">
			<div class="wpeo-button button-blue wpeo-modal-event"
				data-title="<?php echo __( 'Signature de: ', 'digirisk' ) . $participant['rendered']->data['displayname']; ?>"
				data-parent="signature"
				data-target="modal-signature">
				<span><?php esc_html_e( 'Signer', 'digirisk' ); ?></span>
			</div>
			<?php
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/modal', array(
				'action' => 'causerie_save_signature',
				'title'  => __( 'Signature de: ', 'digirisk' ) . $participant['rendered']->data['displayname'],
			) );
			?>
		</td>

	<?php else : ?>
		<td><img class="signature" src="<?php echo esc_attr( wp_get_attachment_url( $participant['signature_id'] ) ); ?>"</td>
	<?php endif; ?>

	<td>
		<div class="wpeo-button button-grey button-square-50 delete action-delete"
			data-id="<?php echo esc_attr( $final_causerie->data['id'] ); ?>"
			data-user-id="<?php echo esc_attr( $participant['user_id'] ); ?>"
			data-action="<?php echo esc_attr( 'causerie_delete_participant' ); ?>"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'causerie_delete_participant' ) ); ?>"
			data-message-delete="<?php esc_attr_e( 'Supprimer ce participant ?', 'digirisk' ); ?>"><i class="icon fa fa-times"></i></div>
	</td>
</tr>
