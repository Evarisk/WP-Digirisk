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

	<td>
		<?php echo do_shortcode( '[digi_signature id="' . $participant['user_id'] . '" parent_id="' . $final_causerie->data['id'] . '" key="participants_signature_id" type="user"]' ); ?>
	</td>

	<td>
		<div class="wpeo-button button-grey button-square-50 delete action-delete"
			data-id="<?php echo esc_attr( $final_causerie->data['id'] ); ?>"
			data-user-id="<?php echo esc_attr( $participant['user_id'] ); ?>"
			data-action="<?php echo esc_attr( 'causerie_delete_participant' ); ?>"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'causerie_delete_participant' ) ); ?>"
			data-message-delete="<?php esc_attr_e( 'Supprimer ce participant ?', 'digirisk' ); ?>"><i class="icon fa fa-times"></i></div>
	</td>
</tr>
