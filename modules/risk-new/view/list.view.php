<?php
/**
 * Affiches la liste des risques
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="table risk">
	<thead>
		<tr>
			<th class="w50 padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
			<th class="w50"><?php esc_html_e( 'Risque', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Cot', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Photo', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Commentaire', 'digirisk' ); ?></th>
			<th class="w150"></th>
		</tr>
	</thead>

	<tbody>
		<?php
		if ( ! empty( $risks ) ) :
			foreach ( $risks as $risk ) :
				\eoxia\View_Util::exec( 'digirisk', 'risk', 'list-item', array(
					'society_id' => $society_id,
					'risk'       => $risk,
					'societies'  => $societies,
				) );
			endforeach;
		endif;
		?>
	</tbody>

	<tfoot>
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'risk', 'item-edit', array(
			'society_id' => $society_id,
			'risk'       => $risk_schema,
		) );
		?>
	</tfoot>
</table>
