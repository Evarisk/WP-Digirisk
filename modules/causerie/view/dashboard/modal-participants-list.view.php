<?php
/**
 * Modal contenu tous les participants avec leurs signatures.
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

<table class="table users">
	<thead>
		<tr>
			<td class="w50 padding"><?php esc_html_e( 'Initial', 'digirisk' ); ?></td>
			<td class="padding"><?php esc_html_e( 'Date signature', 'digirisk' ); ?></td>
			<td class="padding"><?php esc_html_e( 'Signature', 'digirisk' ); ?></td>
		</tr>
	</thead>
	<tbody>
		<?php
		if ( ! empty( $causerie->participants ) ) :
			foreach ( $causerie->participants as $participant ) :
				?>
				<tr>
					<td>
						<?php
						if ( ! empty( $participant['rendered'] ) ) :
							$participant['rendered'] = (array) $participant['rendered'];
							?>
							<div class="avatar" style="background-color: #<?php echo esc_attr( $participant['rendered']['avatar_color'] ); ?>;"><span><?php echo esc_html( $participant['rendered']['initial'] ); ?></span></div>
							<span><?php echo esc_html( $participant['rendered']['displayname'] ); ?></span>
							<?php
						else :
							?><span><?php esc_html_e( 'N/A', 'digirisk' ); ?></span><?php
						endif;
						?>
					</td>
					<td>
						<?php
						if ( ! empty( $participant['signature_date'] ) ) :
							echo esc_html( \eoxia\Date_Util::g()->mysqldate2wordpress( $participant['signature_date'] ) );
						else :
							esc_html_e( 'N/A', 'digirisk' );
						endif;
						?>

					</td>
					<?php if ( empty( $participant['signature_id'] ) ) : ?>
						<td class="signature w50 padding tooltip red signature-tooltip" aria-label="<?php esc_attr_e( 'La signature du participant est obligatoire', 'digirisk' ); ?>">
							<div class="wpeo-button button-blue wpeo-modal-event"
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
						<td><img class="signature" src="<?php echo esc_attr( wp_get_attachment_url( $participant['signature_id'] ) ); ?>"</td>
					<?php endif; ?>
				</tr>
				<?php
			endforeach;
		endif;
		?>
	</tbody>
</table>
