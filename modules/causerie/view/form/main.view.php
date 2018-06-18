<?php
/**
 * Affiches la liste des causeries
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div>
	<h2><?php esc_html_e( 'Bibliothèque des causeries', 'digirisk' ); ?></h2>

	<table class="table add-causerie">
		<thead>
			<tr>
				<th class="w50 padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
				<th class="w50 padding"><?php esc_html_e( 'Photo', 'digirisk' ); ?>.</th>
				<th class="w50 padding"><?php esc_html_e( 'Cat', 'digirisk' ); ?>.</th>
				<th class="padding"><?php esc_html_e( 'Titre et description', 'digirisk' ); ?>.</th>
				<th class="w150"></th>
			</tr>
		</thead>

		<tbody>
			<?php
			if ( ! empty( $causeries ) ) :
				foreach ( $causeries as $causerie ) :
					\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/list-item', array(
						'causerie' => $causerie,
					) );
				endforeach;
			endif;
			?>
		</tbody>

		<tfoot>
			<?php
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/item-edit', array(
				'causerie' => $causerie_schema,
			) );
			?>
		</tfoot>
	</table>

</div>
