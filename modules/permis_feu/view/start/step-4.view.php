<?php
/**
 * liste les intervenants du permis de feu ( dernière étape )
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     7.3.0
 * @version   7.3.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $eo_search; ?>



<div class="information-intervenant-exterieur" style="background-color: #fff; padding: 1em;">
	<input type="hidden" name="user-type" value="intervenant_exterieur">
	<h2 style="text-align:center">
		<?php esc_html_e( 'Responsable des intervenants extérieur', 'digirisk' ); ?>
		<span class="wpeo-tooltip-event"
		aria-label="<?php esc_html_e( 'Responsable de la société intervenante', 'digirisk' ); ?>"
		style="color : dodgerblue; cursor : pointer">
			<i class="fas fa-info-circle"></i>
		</span>
	</h2>
	<?php Permis_feu_Class::g()->display_intervenant_exterieur( array(), $permis_feu->data[ 'id' ] ); ?>
</div>


 <?php if( Prevention_Class::g()->intervenant_is_valid( $permis_feu->data[ 'intervenant_exterieur' ] ) ): ?>
	 <div class="wpeo-button button-blue action-input wpeo-tooltip-event close-permis-feu"
 <?php else: ?>
	 <div class="wpeo-button button-blue button-disable action-input wpeo-tooltip-event close-permis-feu"
 <?php endif; ?>
	data-action="next_step_permis_feu"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_permis_feu' ) ); ?>"
	data-id="<?php echo esc_attr( $permis_feu->data['id'] ); ?>"
	data-parent="digi-permis-feu-parent"
	aria-label="<?php esc_html_e( 'Valider', 'digirisk' ); ?>"
	style="float:right; margin-top: 10px">
	<span><?php esc_html_e( 'Finish', 'digirisk' ); ?> <i class="fas fa-thumbs-up"></i></span>
</div>
