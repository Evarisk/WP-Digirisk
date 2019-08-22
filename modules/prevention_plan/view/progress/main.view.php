<?php
/**
 * La page principale des causeries.
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

<div>
	<h2 style="font-size: 20px; font-weight: normal; margin-bottom: 10px;"><?php esc_html_e( 'Listes des plans de préventions en cours', 'digirisk' ); ?> (<?php echo esc_attr( $nbr ); ?>)</h2>

	<table class="table closed-prevention">
		<thead>
			<tr>
				<td class="w50 padding"><?php esc_html_e( 'ID', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Titre', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Date début', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Date cloture', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Formateur', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Participants', 'digirisk' ); ?></td>
				<td class="w50"></td>
			</tr>
		</thead>
		<?php
		if ( ! empty( $preventions ) ) :
			foreach ( $preventions as $prevention ) :
				\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'progress/table-item', array(
					'prevention' => $prevention,
				) );
			endforeach;
		else :
			?>
			<tr>
				<td colspan="9" style="text-align: center;"><?php esc_html_e( 'Aucun plan de prévention réalisé pour le moment.', 'digirisk' ); ?></td>
			</tr>
			<?php
		endif;
		?>
	</table>
</div>
