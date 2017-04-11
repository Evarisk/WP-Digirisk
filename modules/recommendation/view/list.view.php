<?php
/**
 * Affiches la liste des préconisations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package recommendation
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<table class="table recommendation">
	<thead>
		<tr>
			<th class="padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
			<th class="wm130"><?php esc_html_e( 'Signalisation', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Photo', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Commentaire', 'digirisk' ); ?></th>
			<th class="w100"></th>
		</tr>
	</thead>

	<tbody>
		<?php if ( ! empty( $recommendations ) ) :
			foreach ( $recommendations as $recommendation ) :
				View_Util::exec( 'recommendation', 'list-item', array( 'society_id' => $society_id, 'recommendation' => $recommendation ) );
			endforeach;
		endif; ?>
	</tbody>

	<tfoot>
		<?php View_Util::exec( 'recommendation', 'item-edit', array( 'society_id' => $society_id, 'recommendation' => $recommendation_schema ) ); ?>
	</tfoot>
</table>
