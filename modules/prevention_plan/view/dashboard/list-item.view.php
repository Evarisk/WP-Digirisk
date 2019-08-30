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
	<td class="w50 padding" style="height: 60px">
		#<?php echo esc_attr( $prevention->data[ 'id' ] ); ?>
	</td>
	<td class="padding">
		<?php echo esc_attr( $prevention->data[ 'title' ] ); ?>
	</td>
	<td class="w100 padding">
		<?php echo esc_attr( date( 'd/m/Y', strtotime( $prevention->data[ 'date_start' ][ 'raw' ] ) ) ); ?>
	</td>
	<td class="w100 padding">
		<?php
		if( $prevention->data[ 'date_end__is_define' ] == "undefined" ):
			esc_html_e( 'En cours', 'digirisk' );
		else:
			echo esc_attr( date( 'd/m/Y', strtotime( $prevention->data[ 'date_end' ][ 'raw' ] ) ) );
		endif;
		?>
	</td>
	<td class="padding avatar-info-prevention">
		<?php $name_and_phone = $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->first_name . ' ' . $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->last_name . ' (' . $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->phone . ')'; ?>
		<?php if( $prevention->data[ 'maitre_oeuvre' ][ 'user_id' ] > 0 ) : ?>
			<div class="avatar tooltip hover wpeo-tooltip-event"
				aria-label="<?php echo esc_attr( $name_and_phone ); ?>"
				style="background-color: #<?php echo esc_attr( $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->avator_color ); ?>; cursor : pointer">
					<span><?php echo esc_html( $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->initial ); ?></span>
			</div>
			<div class="info-text" style="display : none">
				<span><?php echo esc_attr( $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->first_name ); ?></span> -
				<span><?php echo esc_attr( $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->last_name ); ?></span>
				<span>( <i><?php echo esc_attr( $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->phone ); ?></i> )</span>
			</div>
		<?php else: ?>
			<?php esc_html_e( 'Aucun maitre oeuvre', 'digirisk' ); ?>
		<?php endif; ?>
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
			<span class="wpeo-button button-red button-square-50 wpeo-tooltip-event delete-this-prevention-plan"
				data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>"
				data-message="<?php esc_html_e( 'Voulez-vous vraiment supprimer ce plan de prévention', 'digirisk' ); ?>"
				data-action="delete_document_prevention"
				data-action="<?php echo esc_attr( wp_create_nonce( 'delete_document_prevention' ) ); ?>"
				aria-label="<?php echo esc_attr_e( 'Supprimer le plan de prévention', 'digirisk' ); ?>">
				<i class="fas fa-times"></i>
			</span>
		</div>
	</td>
</tr>
