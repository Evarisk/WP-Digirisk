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

<div class="wpeo-table table-flex table-duer">
	<div class="table-row table-header">
		<div class="table-cell table-75"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</div>
		<div class="table-cell table-75"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Début', 'digirisk' ); ?></div>
		<div class="table-cell table-75"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Fin', 'digirisk' ); ?></div>
		<div class="table-cell table-75"><?php esc_html_e( 'Destinataire', 'digirisk' ); ?></div>
		<div class="table-cell table-100"><?php esc_html_e( 'Méthodologie', 'digirisk' ); ?></div>
		<div class="table-cell table-75"><?php esc_html_e( 'Sources', 'digirisk' ); ?></div>
		<div class="table-cell table-75"><?php esc_html_e( 'Localisation', 'digirisk' ); ?></div>
		<div class="table-cell table-75"><?php esc_html_e( 'Notes', 'digirisk' ); ?></div>
		<div class="table-cell table-100 table-end"></div>
	</div>

	<?php
	\eoxia\View_Util::exec( 'digirisk', 'duer', 'list', array(
		'documents' => $documents,
	) );

	\eoxia\View_Util::exec( 'digirisk', 'duer', 'item-edit', array(
		'element'    => $element,
		'element_id' => $element_id,
	) );
	?>
</div>

<?php \eoxia\View_Util::exec( 'digirisk', 'duer', 'popup' ); ?>
