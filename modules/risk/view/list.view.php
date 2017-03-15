<?php
/**
 * Affiches la liste des risques
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.7.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<table class="table risk">
	<thead>
		<tr>
			<th class="w50 padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
			<th class="wm130"><?php esc_html_e( 'Risque', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Cot', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Photo', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Commentaire', 'digirisk' ); ?></th>
			<th class="w150"></th>
		</tr>
	</thead>

	<tbody>
		<?php if ( ! empty( $risks ) ) :
			foreach ( $risks as $risk ) :
				View_Util::exec( 'risk', 'list-item', array(
					'society_id' => $society_id,
					'risk' => $risk,
				) );
			endforeach;
		endif; ?>
	</tbody>

	<tfoot>
		<?php View_Util::exec( 'risk', 'item-edit', array(
			'society_id' => $society_id,
			'risk' => $risk_schema,
		) ); ?>
	</tfoot>
</table>
