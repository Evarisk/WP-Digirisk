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

<tr class="item" data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>">
	<td class="w50 padding">
		<strong>
			<span><?php echo esc_html( $prevention->data['id'] ); ?></span>
		</strong>
	</td>

	<td class="padding causerie-description">
		<span class="row-title"><?php echo esc_html( $prevention->data['title'] ); ?></span>
		<span class="row-subtitle"><?php echo esc_html( $prevention->data['content'] ); ?></span>
	</td>

	<td class="padding">
		<span>
			<?php echo esc_attr( $prevention->data[ 'date_start' ][ 'rendered' ][ 'mysql' ] ); ?>
		</span>
	</td>

	<td class="padding">
		<span>
			<?php echo esc_attr( $prevention->data[ 'date_end' ][ 'rendered' ][ 'mysql' ] ); ?>
		</span>
	</td>

	<?php if( ! empty( $prevention->data[ 'maitre_oeuvre' ] ) && $prevention->data[ 'maitre_oeuvre' ][ 'user_id' ] != 0 ): ?>
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
	<?php else: ?>
		<td class="padding">
			<span>
				<?php esc_html_e( 'Aucun', 'digirisk' ); ?>
			</span>
		</td>
	<?php endif; ?>

	<td class="padding">
		<span>
			<?php echo esc_attr( $prevention->data[ 'step' ] ); ?> /5
		</span>
	</td>
	<td class="padding">
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-prevention&id=' . $prevention->data[ 'id' ] ) ); ?>">
			<div class="wpeo-button button-blue">
				<i class="fas fa-play"></i>
			</div>
		</a>
	</td>
</tr>
