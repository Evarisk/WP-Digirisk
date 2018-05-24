<?php
/**
 * Affiches la liste des causeries
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
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
			<th class="w50 padding"><?php esc_html_e( 'Cat', 'digirisk' ); ?>.</th>
			<th class="w50 padding"><?php esc_html_e( 'Titre et description', 'digirisk' ); ?>.</th>
			<th class="w100"></th>
		</tr>
	</thead>

	<tbody>
		<?php
		if ( ! empty( $causeries ) ) :
			foreach ( $causeries as $causerie ) :
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'add/list-item', array(
					'causerie' => $causerie,
				) );
			endforeach;
		endif;
		?>
	</tbody>

	<tfoot>
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'add/item-edit', array(
			'causerie' => $causerie_schema,
		) );
		?>
	</tfoot>
</table>
