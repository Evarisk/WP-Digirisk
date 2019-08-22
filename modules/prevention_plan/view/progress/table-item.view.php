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

	<td class="padding">
		<?php if( ! empty( $prevention->data[ 'former' ] ) && $prevention->data[ 'former' ][ 'user_id' ] != 0 ): ?>
			<?php $user = get_user_by( 'id', $prevention->data[ 'former' ][ 'user_id' ] ) ?>
			<span>
				<?php echo esc_attr( $user->data->display_name ); ?>
			</span>
		<?php else: ?>
			<span>
				<?php esc_html_e( 'Aucun', 'digirisk' ); ?>
			</span>
		<?php endif; ?>
	</td>

	<td class="padding">
		<span>
			X<?php esc_html_e( 'participant(s)', 'digirisk' ); ?>
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
