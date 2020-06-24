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

<div class="table-row item" data-id="<?php echo esc_attr( $permis_feu->data['id'] ); ?>">

	<div class="table-cell causerie-description">
		<span class="row-title"><?php echo esc_html( $permis_feu->data['title'] ); ?></span>
		<span class="row-subtitle"><?php echo esc_html( $permis_feu->data['content'] ); ?></span>
	</div>

	<div class="table-cell table-100">
		<span>
			<?php echo esc_attr( date( 'd-m-Y', strtotime( $permis_feu->data[ 'date_start' ][ 'rendered' ][ 'mysql' ] ) ) ); ?>
		</span>
	</div>

	<?php if( ! empty( $permis_feu->data[ 'maitre_oeuvre' ] ) && $permis_feu->data[ 'maitre_oeuvre' ][ 'user_id' ] != 0 ): ?>
		<div class="table-cell table-50 avatar-info-prevention">
			<?php $name_and_phone = $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->first_name . ' ' . $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->last_name . ' (' . $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->phone . ')'; ?>
			<?php if( $permis_feu->data[ 'maitre_oeuvre' ][ 'user_id' ] > 0 ) : ?>
				<div class="avatar tooltip hover wpeo-tooltip-event"
					aria-label="<?php echo esc_attr( $name_and_phone ); ?>"
					style="background-color: #<?php echo esc_attr( $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->avator_color ); ?>; cursor : pointer">
						<span><?php echo esc_html( $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->initial ); ?></span>
				</div>
				<div class="info-text" style="display : none">
					<span><?php echo esc_attr( $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->first_name ); ?></span> -
					<span><?php echo esc_attr( $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->last_name ); ?></span>
					<span>( <i><?php echo esc_attr( $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->phone ); ?></i> )</span>
				</div>
			<?php else: ?>
				<?php esc_html_e( 'Aucun maitre oeuvre', 'digirisk' ); ?>
			<?php endif; ?>
		</div>
	<?php else: ?>
		<div class="table-cell table-100">
			<span>
				<?php esc_html_e( 'Aucun', 'digirisk' ); ?>
			</span>
		</div>
	<?php endif; ?>

	<div class="table-cell table-100">
		<span>
			<?php if( $permis_feu->data[ 'intervenant_exterieur' ][ 'firstname' ] != "" ): ?>
				<?php echo esc_attr( $permis_feu->data[ 'intervenant_exterieur' ][ 'firstname' ] ); ?> -
				<?php echo esc_attr( $permis_feu->data[ 'intervenant_exterieur' ][ 'lastname' ] ); ?> -
				(<?php echo esc_attr( $permis_feu->data[ 'intervenant_exterieur' ][ 'phone' ] ); ?>)
			<?php else: ?>
				<?php esc_html_e( 'Non-Défini', 'digirisk' ); ?>
			<?php endif; ?>
		</span>
	</div>
	<div class="table-cell table-100">
		<span>
			<?php esc_html_e( sprintf( '%1$d Intervention(s)', count( $permis_feu->data[ 'intervention' ] ) ), 'digirisk' ); ?>
		</span>
	</div>

	<div class="table-cell table-100">
		<span>
			<?php esc_html_e( sprintf( '%1$d Intervenant(s)', count( $permis_feu->data[ 'intervenants' ] ) ), 'digirisk' ); ?>
		</span>
	</div>
	<div class="table-cell table-100">
		<span>
			<?php echo esc_attr( $permis_feu->data[ 'step' ] ); ?> /5
		</span>
	</div>
	<div class="table-cell table-50 table-end">
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-permis-feu&id=' . $permis_feu->data[ 'id' ] ) ); ?>">
			<div class="wpeo-button button-transparent edit button-square-50">
				<i class="fas fa-pen"></i>
			</div>
		</a>
	</div>
</div>
