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

<div class="wpeo-table table-flex risk">
	<div class="table-row table-header">
		<div class="table-cell table-50"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</div>
		<div class="table-cell table-150"><?php esc_html_e( 'Date', 'digirisk' ); ?></div>
		<div class="table-cell table-50"><?php esc_html_e( 'Cot', 'digirisk' ); ?></div>
		<div class="table-cell"><?php esc_html_e( 'Commentaire', 'digirisk' ); ?></div>
	</div>

	<?php if ( ! empty( $evaluations ) ) :
		foreach ( $evaluations as $evaluation ) :
			\eoxia\View_Util::exec( 'digirisk', 'historic', 'risk/list-item', array(
				'evaluation' => $evaluation,
			) );
		endforeach;
	endif; ?>
</div>
