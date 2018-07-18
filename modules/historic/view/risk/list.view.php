<?php
/**
 * Template gérant l'affichage du tableau contenant l'historique de toutes les
 * cotations.
 *
 * Pour chaque ligne du tableau, ce template appel le template list-item.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.2.1
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

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
				\eoxia\View_Util::exec( 'digirisk', 'historic', 'risk/list-item', array(
					'evaluation' => $evaluation,
				) );
			endforeach;
		endif; ?>
	</tbody>
</table>
