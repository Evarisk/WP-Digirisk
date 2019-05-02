<?php
/**
 * Ce template affiche le tableau contenant les DUER présent dans l'application DigiRisk.
 *
 * Ce template appel la vue: "list" et "item-edit".
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<table class="table duer">
	<thead>
		<tr>
			<th class="padding w50"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
			<th class="w100 padding"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Début', 'digirisk' ); ?></th>
			<th class="w100 padding"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Fin', 'digirisk' ); ?></th>
			<th class="w100 padding"><?php esc_html_e( 'Destinataire', 'digirisk' ); ?></th>
			<th class="w100 padding"><?php esc_html_e( 'Méthodologie', 'digirisk' ); ?></th>
			<th class="w100 padding"><?php esc_html_e( 'Sources', 'digirisk' ); ?></th>
			<th class="w100 padding"><?php esc_html_e( 'Localisation', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Notes', 'digirisk' ); ?></th>
			<th class="w100"></th>
		</tr>
	</thead>

	<tbody>
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'duer', 'list', array(
			'documents' => $documents,
		) );
		?>
	</tbody>

	<tfoot>
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'duer', 'item-edit', array(
			'element'    => $element,
			'element_id' => $element_id,
		) );
		?>
	</tfoot>
</table>

<?php \eoxia\View_Util::exec( 'digirisk', 'duer', 'popup' ); ?>
