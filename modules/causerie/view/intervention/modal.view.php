<?php
/**
 * Modal permettant aux utilisateurs de signé lors d'une évaluation de causerie.
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


<div class="wpeo-modal modal-signature">
	<div class="modal-container">

		<!-- Entête -->
		<div class="modal-header">
			<h2 class="modal-title">
				<?php
				if ( ! empty( $title ) ) :
					echo esc_html( $title );
				else :
					esc_html_e( 'Signature de ', 'digirisk' );
				endif;
				?>
			</h2>
			<i class="modal-close fa fa-times"></i>
		</div>

		<!-- Corps -->
		<div class="modal-content">
			<input type="hidden" name="signature_data" />
			<input type="hidden" class="url" value="" />
			<canvas></canvas>
		</div>

		<!-- Footer -->
		<div class="modal-footer">
			<a class="wpeo-button button-erase-signature button-grey button-uppercase">
				<i class="fas fa-eraser"></i>
				<span>Effacer</span>
			</a>

			<a class="wpeo-button button-grey button-uppercase modal-close"><span>Annuler</span></a>

			<?php if ( isset( $action ) ) : ?>
				<a class="wpeo-button button-blue button-uppercase action-input"
					data-namespace="digirisk"
					data-module="causerie"
					data-before-method="applySignature"
					data-parent="item"
					data-action="<?php echo esc_attr( $action ); ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( $action ) ); ?>"><span>Valider</span></a>
			<?php else : ?>
					<a class="wpeo-button button-blue button-uppercase modal-close"><span>Valider</span></a>
			<?php endif; ?>

		</div>
	</div>

</div>
