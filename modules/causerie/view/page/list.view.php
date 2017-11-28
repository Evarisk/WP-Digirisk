<?php
/**
 * Affiches la liste des causeries
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
			<th class="w50 padding"><?php esc_html_e( 'Photo', 'digirisk' ); ?>.</th>
			<th class="w50 padding"><?php esc_html_e( 'Nom', 'digirisk' ); ?>.</th>
			<th class="w50 padding"><?php esc_html_e( 'Catégorie', 'digirisk' ); ?>.</th>
			<th class="w50 padding"><?php esc_html_e( 'Descriptif', 'digirisk' ); ?>.</th>
			<th class="w50 padding"><?php esc_html_e( 'Documents joints', 'digirisk' ); ?>.</th>
			<th class="w100"></th>
		</tr>
	</thead>

	<tbody>
		<?php
		if ( ! empty( $causeries ) ) :
			foreach ( $causeries as $causerie ) :
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'page/list-item', array(
					'causerie' => $causerie,
				) );
			endforeach;
		endif;
		?>
	</tbody>

	<tfoot>
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'page/item-edit', array(
			'causerie' => $causerie_schema,
			'main_society' => $main_society,
		) );
		?>
	</tfoot>
</table>
