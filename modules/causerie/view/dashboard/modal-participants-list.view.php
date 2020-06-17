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

<div class="wpeo-table table-flex users">
	<div class="table-row table-header">
		<div class="table-cell table-50"><?php esc_html_e( 'Initial', 'digirisk' ); ?></div>
		<div class="table-cell"><?php esc_html_e( 'Date signature', 'digirisk' ); ?></div>
		<div class="table-cell table-50"><?php esc_html_e( 'Signature', 'digirisk' ); ?></div>
	</div>
	<?php
	if ( ! empty( $causerie->data['participants'] ) ) :
		foreach ( $causerie->data['participants'] as $participant ) :
			?>
			<div class="table-row">
				<div class="table-cell table-50">
					<?php

					$key = 'participants_signature_id_' . $causerie->data['id'];

					if( is_multisite() ) :
						$key = $GLOBALS['wpdb']->prefix . $key;
					endif;

					$signature_id = get_user_meta( $participant['user_id'], $key, true );
					$participant['signature_date'] = get_user_meta( $participant['user_id'], $key . '_' . $signature_id . '_date', true );
					if ( ! empty( $participant['rendered'] ) ) :
						$participant['rendered'] = (array) $participant['rendered'];
						?>
						<div class="avatar wpeo-tooltip-event" aria-label="<?php echo esc_attr( $participant['rendered']['data']['displayname'] ); ?>" style="background-color: #<?php echo esc_attr( $participant['rendered']['data']['avatar_color'] ); ?>;"><span><?php echo esc_html( $participant['rendered']['data']['initial'] ); ?></span></div>
						<?php
					else :
						?><span><?php esc_html_e( 'N/A', 'digirisk' ); ?></span><?php
					endif;
					?>
				</div>
				<div class="table-cell">
					<?php
					if ( ! empty( $participant['signature_date'] ) ) :
						echo esc_html( \eoxia\Date_Util::g()->mysqldate2wordpress( $participant['signature_date'] ) );
					else :
						esc_html_e( 'N/A', 'digirisk' );
					endif;
					?>

				</div>
				<?php
				if ( empty( $signature_id ) ) : ?>
					<div class="table-cell signature table-50 tooltip red signature-tooltip" aria-label="<?php esc_attr_e( 'La signature du participant est obligatoire', 'digirisk' ); ?>">
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
					</div>

				<?php else : ?>
					<div class="table-cell table-50"><img class="signature" src="<?php echo esc_attr( wp_get_attachment_url( $signature_id ) ); ?>"</div>
				<?php endif; ?>
			</div>
			<?php
		endforeach;
	endif;
	?>
</div>
