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

<ul class="permis-feu-stats wpeo-gridlayout grid-4">
	Some stats here
</ul>

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
	<?php Permis_Feu_Class::g()->display_maitre_oeuvre( $permis_feu ); ?>
</div>

<?php if( isset( $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ] ) && $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->first_name != "" && $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->last_name != ""  && $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->phone && $permis_feu->data[ 'maitre_oeuvre' ][ 'signature_id' ] != 0 ): ?>
	<div class="wpeo-button wpeo-tooltip-event button-blue action-input permis-feu-start"
<?php else: ?>
	<div class="wpeo-button wpeo-tooltip-event button-blue action-input permis-feu-start button-disable"
<?php endif; ?>
		data-parent="ajax-content"
		data-action="next_step_permis_feu"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_permis_feu' ) ); ?>"
		data-id="<?php echo esc_attr( $permis_feu->data['id'] ); ?>"
		aria-label="<?php esc_html_e( 'Suivant', 'digirisk' ); ?>"
		style="float:right">
		<span><i class="fas fa-2x fa-long-arrow-alt-right"></i></span>
	</div>
</div>
