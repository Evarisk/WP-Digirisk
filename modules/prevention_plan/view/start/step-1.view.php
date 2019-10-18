<?php
/**
 * Premiere page dans la création d'un plan de prévention
 * Ajoute un formateur avec sa signature
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

<div class="information-maitre-oeuvre" style="background-color: #fff; padding: 1em;">
	<input type="hidden" name="user-type" value="maitre_oeuvre">
	<h2 style="text-align:center">
		<?php esc_html_e( 'Maitre d\'oeuvre', 'digirisk' ); ?> -
		<i><?php echo esc_attr( $society->data[ 'title' ] ); ?></i>
		<span class="wpeo-tooltip-event"
		aria-label="<?php esc_html_e( 'Responsable de la maitrise d\'ouvrage', 'digirisk' ); ?>"
		style="color : dodgerblue; cursor : pointer">
			<i class="fas fa-info-circle"></i>
		</span>
	</h2>
	<?php Prevention_Class::g()->display_maitre_oeuvre( array(), $prevention->data[ 'id' ] ); ?>
</div>

<?php if( isset( $prevention->data[ 'maitre_oeuvre' ][ 'data' ] ) && $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->first_name != "" && $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->last_name != ""  && $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->phone && $prevention->data[ 'maitre_oeuvre' ][ 'signature_id' ] != 0 ): ?>
	<div class="wpeo-button wpeo-tooltip-event button-blue action-input prevention-start"
<?php else: ?>
	<div class="wpeo-button wpeo-tooltip-event button-blue action-input prevention-start button-disable"
<?php endif; ?>
		data-parent="ajax-content"
		data-action="next_step_prevention"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_prevention' ) ); ?>"
		data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>"
		aria-label="<?php esc_html_e( 'Suivant', 'digirisk' ); ?>"
		style="float:right; margin-top : 10px">
		<span><i class="fas fa-2x fa-long-arrow-alt-right"></i></span>
	</div>
</div>
