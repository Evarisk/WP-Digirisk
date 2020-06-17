<?php
/**
 * Causeries déjà effectuées.
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

<div class="table-row item" data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>">
	<div class="table-cell causerie-description">
		<span class="row-title"><?php echo esc_html( $prevention->data['title'] ); ?></span>
		<span class="row-subtitle"><?php echo esc_html( $prevention->data['content'] ); ?></span>
	</div>

	<div class="table-cell table-150">
		<span>
			<?php echo esc_attr( date( 'd-m-Y', strtotime( $prevention->data[ 'date_start' ][ 'rendered' ][ 'mysql' ] ) ) ); ?>
		</span>
	</div>

	<?php if( ! empty( $prevention->data[ 'maitre_oeuvre' ] ) && $prevention->data[ 'maitre_oeuvre' ][ 'user_id' ] != 0 ): ?>
		<div class="table-cell table-150 avatar-info-prevention">
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
		</div>
	<?php else: ?>
		<div class="table-cell table-150">
			<span>
				<?php esc_html_e( 'Aucun', 'digirisk' ); ?>
			</span>
		</div>
	<?php endif; ?>

	<div class="table-cell table-150">
		<span>
			<?php if( $prevention->data[ 'intervenant_exterieur' ][ 'firstname' ] != "" ): ?>
				<?php echo esc_attr( $prevention->data[ 'intervenant_exterieur' ][ 'firstname' ] ); ?> -
				<?php echo esc_attr( $prevention->data[ 'intervenant_exterieur' ][ 'lastname' ] ); ?> -
				(<?php echo esc_attr( $prevention->data[ 'intervenant_exterieur' ][ 'phone' ] ); ?>)
			<?php else: ?>
				<?php esc_html_e( 'Non-Défini', 'digirisk' ); ?>
			<?php endif; ?>
		</span>
	</div>

	<div class="table-cell table-150">
		<span>
			<?php esc_html_e( sprintf( '%1$d Intervention(s)', count( $prevention->data[ 'intervention' ] ) ), 'digirisk' ); ?>
		</span>
	</div>

	<div class="table-cell table-150">
		<span>
			<?php esc_html_e( sprintf( '%1$d Intervenant(s)', count( $prevention->data[ 'intervenants' ] ) ), 'digirisk' ); ?>
		</span>
	</div>

	<div class="table-cell table-150">
		<span>
			<?php echo esc_attr( $prevention->data[ 'step' ] ); ?> /5
		</span>
	</div>
	<div class="table-cell table-50 table-end">
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-prevention&id=' . $prevention->data[ 'id' ] ) ); ?>">
			<div class="wpeo-button button-blue">
				<i class="fas fa-pen"></i>
			</div>
		</a>
	</div>
</div>
