<?php
/**
 * Déclares le tableau qui contient les documents unique
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="table duer">
	<thead>
		<tr>
			<th class="padding w50"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
			<th class="w100 padding"><i class="fa fa-calendar-o icon"></i><?php esc_html_e( 'Début', 'digirisk' ); ?></th>
			<th class="w100 padding"><i class="fa fa-calendar-o icon"></i><?php esc_html_e( 'Fin', 'digirisk' ); ?></th>
			<th class="w100 padding"><?php esc_html_e( 'Destinataire', 'digirisk' ); ?></th>
			<th class="w100 padding"><?php esc_html_e( 'Méthodologie', 'digirisk' ); ?></th>
			<th class="w100 padding"><?php esc_html_e( 'Sources', 'digirisk' ); ?></th>
			<th class="w100 padding"><?php esc_html_e( 'Localisation', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Notes', 'digirisk' ); ?></th>
			<th class="w100"></th>
		</tr>
	</thead>

	<tbody>
		<?php DUER_Class::g()->display_document_list( $element_id ); ?>
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
