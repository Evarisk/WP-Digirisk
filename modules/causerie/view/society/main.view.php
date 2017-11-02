<?php
/**
 * Apelle la vue list.view du module causerie
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="table causerie">
	<thead>
		<tr>
			<th class="w50 padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
			<th class="w50"><?php esc_html_e( 'Photo', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Titre et date', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Cat.', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Doc. Joints', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Formateur', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Person. présent', 'digirisk' ); ?></th>
			<th class="w150"></th>
		</tr>
	</thead>

	<tbody>
		<?php
		if ( ! empty( $causeries ) ) :
			foreach ( $causeries as $causerie ) :
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'society/list-item', array(
					'society_id' => $society_id,
					'causerie' => $causerie,
				) );
			endforeach;
		endif;
		?>
	</tbody>

	<tfoot>
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'society/item-edit', array(
			'society_id' => $society_id,
			'causerie' => $causerie_schema,
		) );
		?>
	</tfoot>
</table>
