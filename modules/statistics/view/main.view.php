<?php
/**
 * Template pour les statistiques.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2020 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     7.5.3
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="statistics-chart" data-id="<?php echo esc_attr( $id ); ?>">
	<h3><?php esc_html_e( 'Statistiques', 'digirisk' ); ?></h3>
	<div class="wpeo-button button-square-50 action-input add"
		data-id="<?php echo esc_attr( $id ); ?>"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'export_csv_file' ) ); ?>"
		data-action="export_csv_file">
		<i class="button-icon fas fa-plus"></i>
	</div>
	<div class="wpeo-gridlayout grid-2">
		<?php for ( $i = 0; $i < 6; $i++ ) : ?>
		<div>
			<canvas id="myChart[<?php echo esc_attr( $i ); ?>]" max-width="400" max-height="400"></canvas>
		</div>
		<?php endfor; ?>
	</div>
</div>
