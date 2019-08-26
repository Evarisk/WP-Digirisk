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

<div class="information-maitre-oeuvre" style="background-color: #fff; padding: 1em;">
	<input type="hidden" name="user-type" value="maitre_oeuvre">
	<h2 style="text-align:center">
		<?php esc_html_e( 'Maitre d\'oeuvre', 'digirisk' ); ?> -
		<i><?php echo esc_attr( $society->data[ 'title' ] ); ?></i>
	</h2>
	<?php Prevention_Class::g()->display_maitre_oeuvre( array(), $prevention->data[ 'id' ] ); ?>
</div>

<div class="information-intervenant-exterieur" style="background-color: #fff; padding: 1em;">
	<input type="hidden" name="user-type" value="intervenant_exterieur">
	<h2 style="text-align:center"><?php esc_html_e( 'Intervenant Extérieur', 'digirisk' ); ?></h2>
	<?php Prevention_Class::g()->display_intervenant_exterieur( array(), $prevention->data[ 'id' ] ); ?>
</div>
<?php /* ?>
<div class="wpeo-button button-blue action-input wpeo-tooltip-event button-disable prevention-cloture"
*/
?><div class="wpeo-button button-blue action-input wpeo-tooltip-event prevention-cloture"
	data-action="next_step_prevention"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_prevention' ) ); ?>"
	data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>"
	data-parent="digi-prevention-parent"
	aria-label="<?php esc_html_e( 'Valider', 'digirisk' ); ?>"
	style="float:right; margin-top: 10px">
	<span><?php esc_html_e( 'Finish', 'task-manager' ); ?> <i class="fas fa-thumbs-up"></i></span>
</div>
