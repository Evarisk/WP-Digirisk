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

defined( 'ABSPATH' ) || exit;

/**
 * Documentation des variables de la vue.
 *
 * @var integer $signature_id L'ID de la signature (wp_posts)
 */

?>
<div class="form-element <?php echo $key; ?>" >
	<?php if ( ! empty( $title ) ) : ?>
		<span class="form-label"><?php echo esc_attr( $title ); ?></span>
	<?php endif; ?>

	<label class="form-field-container">
		<?php
		if ( empty( $signature_id ) ) :
			?>
			<div class="wpeo-button button-blue wpeo-modal-event button-signature"
			     data-id="<?php echo esc_attr( $id ); ?>"
			     data-key="<?php echo esc_attr( $key ); ?>"
			     data-type="<?php echo esc_attr( $type ); ?>"
			     data-class="modal-signature"
				 data-title="Signature"
				 data-action="load_modal_signature">
				<input type="hidden" name="user_signature" />
				<span><?php esc_html_e( 'Signer', 'digirisk' ); ?></span>
			</div>
			<?php
		else :
			?>
			<div class="signature-image wpeo-button-pulse wpeo-modal-event button-signature"
			    data-class="modal-signature"
				data-id="<?php echo esc_attr( $id ); ?>"
			    data-key="<?php echo esc_attr( $key ); ?>"
			    data-type="<?php echo esc_attr( $type ); ?>"
			    data-url="<?php echo wp_get_attachment_url( $signature_id ); ?>"
			    aria-label="Modifier la signature"
			    data-action="load_modal_signature"
			    data-title="<?php esc_html_e( 'Signature de l\'utilisateur: ' , 'task-manager' ); ?>">
				<input type="hidden" name="user_signature" value="<?php echo wp_get_attachment_url( $signature_id ); ?>" />
				<img class="signature" src="<?php echo esc_attr( wp_get_attachment_url( $signature_id ) ); ?>">
				<span class="button-float-icon animated wpeo-tooltip-event" aria-label="Modifier la signature"><i class="fas fa-pencil-alt"></i></span>
			</div>
			<?php
		endif;
		?>

	</label>
</div>
