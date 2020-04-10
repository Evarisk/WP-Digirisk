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

<div class="wpeo-table table-flex table-statistics">
	<div class="table-row table-header">
		<div class="table-cell table-75"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</div>
		<div class="table-cell"><?php esc_html_e( 'Nom', 'digirisk' ); ?></div>
		<div class="table-cell table-50 table-end"></div>
	</div>

	<?php if ( ! empty( $documents ) ) : ?>
		<?php foreach ( $documents as $element ) : ?>
			<?php \eoxia\View_Util::exec( 'digirisk', 'statistics', 'list-item', array( 'element' => $element ) ); ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php
	\eoxia\View_Util::exec( 'digirisk', 'statistics', 'item-edit', array(
		'id' => $id,
	) );
	?>
</div>

<br>

<div class="statistics-chart" data-id="<?php echo esc_attr( $id ); ?>">
	<div class="wpeo-gridlayout grid-1">
		<?php for ( $i = 0; $i < $nb_chart_display; $i++ ) : ?>
		<div>
			<canvas id="myChart[<?php echo esc_attr( $i ); ?>]" max-width="400" max-height="400"></canvas>
		</div>
		<?php endfor; ?>
	</div>
</div>
