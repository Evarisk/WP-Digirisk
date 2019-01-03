<?php
/**
 * Affiches le tableau de donnée
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.6
 * @copyright 2015-2019 Evarisk
 * @package society
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="table addded-risks">
	<thead>
		<tr>
			<th><?php esc_html_e( 'Date de création', 'digirisk' ); ?></th>
			<th class="w100"><?php esc_html_e( 'Ref', 'digirisk' ); ?></th>
			<th class="w50"><?php esc_html_e( 'Risque', 'digirisk' ); ?></th>
			<th class="w50"><?php esc_html_e( 'Quot.', 'digirisk' ); ?></th>
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
