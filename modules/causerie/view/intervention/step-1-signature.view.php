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

use eoxia\View_Util;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="table-cell signature table-100">
	<input type="hidden" name="have_signature" value="true" />

	<div class="signature-image wpeo-button-pulse wpeo-modal-event"
		data-url="<?php echo wp_get_attachment_url( $final_causerie->data['former']['signature_id'] ); ?>"
		aria-label="Modifier la signature"
		data-parent="signature"
		data-target="modal-signature"
		data-title="<?php esc_html_e( 'Signature de l\'utilisateur: ' , 'task-manager' ); ?>">
		<img class="signature" src="<?php echo esc_attr( wp_get_attachment_url( $final_causerie->data['former']['signature_id'] ) ); ?>">
		<span class="button-float-icon animated wpeo-tooltip-event" aria-label="Modifier la signature"><i class="fas fa-pencil-alt"></i></span>
		<?php
		View_Util::exec( 'digirisk', 'causerie', 'intervention/modal', array(
			'action' => 'causerie_save_signature',
		) );
		?>
	</div>
</div>
