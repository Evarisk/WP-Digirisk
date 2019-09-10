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



 <div style="background-color: #fff; padding: 1em;">
 	<h2 style="text-align:center">
		<?php esc_html_e( 'Liste des intervenants extérieur', 'digirisk' ); ?>
		<span class="wpeo-tooltip-event"
		aria-label="<?php esc_html_e( 'Liste des intervenants du permis de feu', 'digirisk' ); ?>"
		style="color : dodgerblue; cursor : pointer">
			<i class="fas fa-info-circle"></i>
		</span>
	</h2>
	<?php if( isset( $text_info ) && $text_info != "" ): ?>
		<span style="color : green">
		<?php echo esc_attr( $text_info ); ?>
	</span>
	<?php endif; ?>
	 <?php Permis_Feu_Class::g()->display_list_intervenant( $permis_feu->data['id'] ); ?>
 </div>

<div class="wpeo-button button-blue action-input wpeo-tooltip-event"
	data-action="next_step_permis_feu"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_permis_feu' ) ); ?>"
	data-id="<?php echo esc_attr( $permis_feu->data['id'] ); ?>"
	data-parent="digi-prevention-parent"
	aria-label="<?php esc_html_e( 'Valider', 'digirisk' ); ?>"
	style="float:right; margin-top: 10px">
	<span><?php esc_html_e( 'Finish', 'digirisk' ); ?> <i class="fas fa-thumbs-up"></i></span>
</div>
