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

<div class="table-row item" data-id="<?php echo esc_attr( $prevention->data[ 'id' ] ); ?>">
	<div class="table-cell table-50 padding" style="height: 60px">
		<?php echo esc_attr( $prevention->data[ 'unique_identifier' ] ); ?>
	</div>
	<div class="table-cell">
		<?php echo esc_attr( $prevention->data[ 'title' ] ); ?>
	</div>
	<div class="table-cell table-100">
		<?php echo esc_attr( date( 'd/m/Y', strtotime( $prevention->data[ 'date_start' ][ 'raw' ] ) ) ); ?>
	</div>
	<div class="table-cell table-100">
		<?php if( $prevention->data[ 'date_end__is_define' ] == "undefined" ): ?>
			<?php esc_html_e( 'En cours', 'digirisk' ); ?>
		<?php else: ?>
			<?php echo esc_attr( date( 'd/m/Y', strtotime( $prevention->data[ 'date_end' ][ 'raw' ] ) ) ); ?>
		<?php endif; ?>
	</div>
	<div class="table-cell table-100 avatar-info-prevention">
		<?php $name_and_phone = $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->first_name . ' ' . $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->last_name;
		if ( ! empty( $prevention->data['maitre_oeuvre']['data']->phone ) ) :
		$name_and_phone .= ' (' . $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->phone . ')';
		endif;

		if( $prevention->data[ 'maitre_oeuvre' ][ 'user_id' ] > 0 ) : ?>
			<div class="avatar tooltip hover wpeo-tooltip-event"
				aria-label="<?php echo esc_attr( $name_and_phone ); ?>"
				style="background-color: #<?php echo esc_attr( $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->avator_color ); ?>; cursor : pointer">
					<span><?php echo esc_html( $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->initial ); ?></span>
			</div>
		<?php else: ?>
			<?php esc_html_e( 'Aucun maitre oeuvre', 'digirisk' ); ?>
		<?php endif; ?>
	</div>
	<div class="table-cell table-100">
		<?php echo esc_attr( $prevention->data[ 'intervenant_exterieur' ]['firstname'] . ' ' . $prevention->data[ 'intervenant_exterieur' ]['lastname'] );
		if ( ! empty( $prevention->data['intervenant_exterieur']['phone'] ) ) :
			?>
			<i>(<?php echo esc_attr( $prevention->data[ 'intervenant_exterieur' ][ 'phone' ] ); ?>)</i>
			<?php
		endif;
		?>
	</div>
	<div class="table-cell table-100">
		<?php echo esc_attr( count( $prevention->data[ 'intervenants' ] ) ); ?> <?php esc_html_e( 'intervenant(s)', 'digirisk' ); ?>
	</div>
	<div class="table-cell table-100">
		<?php echo esc_attr( count( $prevention->data[ 'intervention' ] ) ); ?> <?php esc_html_e( 'intervention(s)', 'digirisk' ); ?>
	</div>
	<div class="table-cell table-150">
		<div class="action">
			<span class="action-attribute wpeo-button button-blue button-square-50 wpeo-tooltip-event"
				data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>"
				data-action="edit_this_prevention"
				data-action="<?php echo esc_attr( wp_create_nonce( 'edit_this_prevention' ) ); ?>"
				aria-label="<?php echo esc_attr_e( 'Modifier ce plan de prévention', 'digirisk' ); ?>">
				<i class="fas fa-pen" style=""></i>
			</span>

			<span class="action-attribute wpeo-button button-green button-square-50 wpeo-tooltip-event"
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
	</div>
</div>
