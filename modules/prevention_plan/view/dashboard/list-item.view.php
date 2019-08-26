<?php
/**
 * Plan de prévention déja effecutés (dashboard)
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

<tr class="item" data-id="<?php echo esc_attr( $prevention->data[ 'id' ] ); ?>">
	<td class="w50 padding">
		#<?php echo esc_attr( $prevention->data[ 'id' ] ); ?>
	</td>
	<td class="padding">
		<?php echo esc_attr( $prevention->data[ 'title' ] ); ?>
	</td>
	<td class="w100 padding">
		<?php echo esc_attr( date( 'd/m/Y', strtotime( $prevention->data[ 'date_start' ][ 'raw' ] ) ) ); ?>
	</td>
	<td class="w100 padding">
		<?php echo esc_attr( date( 'd/m/Y', strtotime( $prevention->data[ 'date_closure' ][ 'raw' ] ) ) ); ?>
	</td>
	<td class="padding">
		<div class="avatar tooltip hover wpeo-tooltip-event"
			aria-label="<?php echo esc_attr( $prevention->data[ 'former' ][ 'data' ]->display_name ); ?>"
			style="background-color: #<?php echo esc_attr( $prevention->data[ 'former' ][ 'data' ]->avator_color ); ?>;">
				<span><?php echo esc_html( $prevention->data[ 'former' ][ 'data' ]->initial ); ?></span>
		</div>
	</td>
	<td class="padding">
		<?php echo esc_attr( $prevention->data[ 'maitre_oeuvre' ][ 'firstname' ] ); ?> -
		<?php echo esc_attr( $prevention->data[ 'maitre_oeuvre' ][ 'lastname' ] ); ?>
		<i>(<?php echo esc_attr( $prevention->data[ 'maitre_oeuvre' ][ 'phone' ] ); ?>)</i>
	</td>
	<td class="padding">
		<?php echo esc_attr( $prevention->data[ 'intervenant_exterieur' ][ 'firstname' ] ); ?> -
		<?php echo esc_attr( $prevention->data[ 'intervenant_exterieur' ][ 'lastname' ] ); ?>
		<i>(<?php echo esc_attr( $prevention->data[ 'intervenant_exterieur' ][ 'phone' ] ); ?>)</i>
	</td>
	<td class="padding">
		<?php echo esc_attr( count( $prevention->data[ 'intervenants' ] ) ); ?> <?php esc_html_e( 'intervenant(s)', 'digirisk' ); ?>
	</td>
	<td class="padding">
		<?php echo esc_attr( count( $prevention->data[ 'intervention' ] ) ); ?> <?php esc_html_e( 'intervention(s)', 'digirisk' ); ?>
	</td>
	<td class="w50">
		<div class="action">
			<span class="action-attribute wpeo-button button-blue button-square-50 wpeo-tooltip-event"
				data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>"
				data-action="generate_document_prevention"
				data-action="<?php echo esc_attr( wp_create_nonce( 'generate_document_prevention' ) ); ?>"
				aria-label="<?php echo esc_attr_e( 'Générer le document', 'digirisk' ); ?>">
				<i class="fas fa-download"></i>
			</span>
		</div>
	</td>
</tr>
