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
	 <?php Prevention_Class::g()->display_intervenant_exterieur( array(), $prevention->data[ 'id' ] ); ?>
 </div>

<?php /* ?>
<div class="wpeo-button button-blue action-input wpeo-tooltip-event button-disable prevention-cloture"
*/
?>

<?php if( Prevention_Class::g()->intervenant_is_valid( $prevention->data[ 'intervenant_exterieur' ] ) ): ?>
	<div class="wpeo-button button-blue action-input wpeo-tooltip-event go-to-last-step-prevention"
<?php else: ?>
	<div class="wpeo-button button-blue button-disable action-input wpeo-tooltip-event go-to-last-step-prevention"
<?php endif; ?>
	data-action="next_step_prevention"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_prevention' ) ); ?>"
	data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>"
	data-parent="digi-prevention-parent"
	aria-label="<?php esc_html_e( 'Valider', 'digirisk' ); ?>"
	style="float:right; margin-top: 10px">
	<span><?php esc_html_e( 'Finish', 'task-manager' ); ?> <i class="fas fa-thumbs-up"></i></span>
</div>
