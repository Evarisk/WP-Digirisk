<?php
/**
 * Affiches la liste des causeries
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



 <div style="background-color: #fff; padding: 1em;">
 	<h2 style="text-align:center">
		<?php esc_html_e( 'Liste des intervenants extérieur', 'digirisk' ); ?>
		<span class="wpeo-tooltip-event"
		aria-label="<?php esc_html_e( 'Liste des intervenants du plan de  prévention', 'digirisk' ); ?>"
		style="color : dodgerblue; cursor : pointer">
			<i class="fas fa-info-circle"></i>
		</span>
	</h2>
	 <?php Prevention_Class::g()->display_list_intervenant( $prevention->data['id'] ); ?>
 </div>

<?php /* ?>
<div class="wpeo-button button-blue action-input wpeo-tooltip-event button-disable prevention-cloture"
*/
?><div class="wpeo-button button-blue action-input wpeo-tooltip-event"
	data-action="next_step_prevention"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_prevention' ) ); ?>"
	data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>"
	data-parent="digi-prevention-parent"
	aria-label="<?php esc_html_e( 'Valider', 'digirisk' ); ?>"
	style="float:right; margin-top: 10px">
	<span><?php esc_html_e( 'Finish', 'task-manager' ); ?> <i class="fas fa-thumbs-up"></i></span>
</div>
