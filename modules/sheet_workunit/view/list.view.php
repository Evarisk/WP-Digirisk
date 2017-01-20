<?php
/**
 * La liste des fiches des unités de travail
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package sheet_workunit
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<thead>
	<tr>
		<th class="padding"><?php \esc_html_e( 'Ref', 'digirisk' ); ?></th>
		<th><?php \esc_html_e( 'Nom', 'digirisk' ); ?></th>
		<th class="w50"></th>
	</tr>
</thead>

<tbody>
	<?php if ( ! empty( $list_document ) ) : ?>
		<?php foreach ( $list_document as $element ) : ?>
			<?php View_Util::exec( 'sheet_workunit', 'list-item', array( 'element' => $element, 'element_id' => $element_id ) ); ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php View_Util::exec( 'sheet_workunit', 'item-edit', array( 'element_id' => $element_id ) ); ?>
</tbody>
