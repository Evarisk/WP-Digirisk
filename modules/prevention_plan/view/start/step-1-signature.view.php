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

<div class="signature-image wpeo-button-pulse wpeo-modal-event"
	data-url="<?php echo wp_get_attachment_url( $prevention->data[ $user_type ]['signature_id'] ); ?>"
	aria-label="Modifier la signature"
	data-parent="form-element"
	data-target="modal-signature"
	data-title="<?php esc_html_e( 'Signature Maitre d\'oeuvre', 'task-manager' ); ?>">
	<img class="signature" src="<?php echo esc_attr( wp_get_attachment_url( $prevention->data[ $user_type ]['signature_id'] ) ); ?>">
	<span class="button-float-icon animated wpeo-tooltip-event" aria-label="Modifier la signature"><i class="fas fa-pencil-alt"></i></span>
	<?php
	\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-1-signature-modal', array(
		'action'         => 'prevention_save_signature_maitre_oeuvre',
		'parent_element' => $parent,
	) );
	?>
</div>


<?php if( isset( $user_type_attr ) && $user_type_attr != "" ): ?>
	<input type="hidden" name="<?php echo esc_attr( $user_type_attr ); ?>" value="ok">
<?php endif; ?>
