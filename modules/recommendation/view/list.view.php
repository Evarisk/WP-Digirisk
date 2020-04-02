<?php
/**
 * Le template pour afficher le tableau des signalisations.
 *
 * Ce template appel deux templates supplémentaires, "list-item" qui correspond
 * aux lignes du tableau, et "item-edit" qui correspond à la ligne d'ajout
 * d'une signalisation.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-only.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.2.1
 * @version   7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="wpeo-table table-flex table-recommendation">
	<div class="table-row table-header">
		<div class="table-cell table-75"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</div>
		<div class="table-cell table-100"><?php esc_html_e( 'Signalisation', 'digirisk' ); ?></div>
		<div class="table-cell table-50"><?php esc_html_e( 'Photo', 'digirisk' ); ?></div>
		<div class="table-cell"><?php esc_html_e( 'Commentaire', 'digirisk' ); ?></div>
		<div class="table-cell table-100 table-end"></div>
	</div>

	<?php
	if ( ! empty( $recommendations ) ) :
		foreach ( $recommendations as $recommendation ) :
			\eoxia\View_Util::exec( 'digirisk', 'recommendation', 'list-item', array(
				'society_id'     => $society_id,
				'recommendation' => $recommendation,
			) );
		endforeach;
	endif;

	\eoxia\View_Util::exec( 'digirisk', 'recommendation', 'item-edit', array(
		'society_id'     => $society_id,
		'recommendation' => $recommendation_schema,
	) );
	?>
</div>
