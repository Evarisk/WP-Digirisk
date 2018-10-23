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
		<?php
		if ( ! empty( $recommendations ) ) :
			foreach ( $recommendations as $recommendation ) :
				\eoxia\View_Util::exec( 'digirisk', 'recommendation', 'list-item', array(
					'society_id'     => $society_id,
					'recommendation' => $recommendation,
				) );
			endforeach;
		endif;
		?>
	</tbody>

	<tfoot>
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'recommendation', 'item-edit', array(
			'society_id'     => $society_id,
			'recommendation' => $recommendation_schema,
		) );
		?>
	</tfoot>
</table>
