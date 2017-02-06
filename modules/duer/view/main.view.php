<?php
/**
 * Déclares le tableau qui contient les documents unique
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package document
 * @subpackage view
 */

namespace digi;
if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

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
			<th class="w150"></th>
		</tr>
	</thead>

	<tbody>
		<?php DUER_Class::g()->display_document_list( $element_id ); ?>
	</tbody>

	<tfoot>
		<?php View_Util::exec( 'duer', 'item-edit', array( 'element' => $element, 'element_id' => $element_id ) ); ?>
	</tfoot>
</table>

<?php View_Util::exec( 'duer', 'popup' ); ?>
