<?php
/**
 * Affiches l'historique des cotations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.10.0
 * @version 6.2.10.0
 * @copyright 2015-2017 Evarisk
 * @package historic
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<table class="table risk">
	<thead>
		<tr>
			<th class="w50 padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
			<th><?php esc_html_e( 'Date', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Cot', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Commentaire', 'digirisk' ); ?></th>
		</tr>
	</thead>

	<tbody>
		<?php if ( ! empty( $evaluations ) ) :
			foreach ( $evaluations as $evaluation ) :
				\eoxia001\View_Util::exec( 'digirisk', 'historic', 'risk/list-item', array(
					'evaluation' => $evaluation,
				) );
			endforeach;
		endif; ?>
	</tbody>
</table>
