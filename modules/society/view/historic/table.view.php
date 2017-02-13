<?php
/**
 * Affiches le tableau de donnée
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.6.0
 * @version 6.2.6.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<table class="table addded-risks">
	<thead>
		<tr>
			<th>Date de création</th>
			<th class="w100">Ref</th>
			<th class="w50">Risque</th>
			<th class="w50">Quot.</th>
		</tr>
	</thead>

	<tbody>
		<?php if ( ! empty( $risks ) ) : ?>
			<?php foreach ( $risks as $risk ) : ?>
				<tr>
					<td><?php echo esc_html( $risk->date ); ?></td>
					<td><?php echo esc_html( $risk->unique_identifier . ' - ' . $risk->evaluation->unique_identifier ); ?></td>
					<td><?php do_shortcode( '[dropdown_danger id="' . $risk->id . '" type="risk" display="view"]' ); ?></td>
					<td><?php do_shortcode( '[digi_evaluation_method risk_id=' . $risk->id . ' display="view"]' ); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
