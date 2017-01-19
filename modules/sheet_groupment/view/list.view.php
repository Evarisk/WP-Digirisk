<?php
/**
 * La liste des fiches de groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package sheet_groupment
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<thead>
	<tr>
		<th class="padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
		<th class="padding"><?php esc_html_e( 'Nom', 'digirisk' ); ?></th>
		<th class="w50"></th>
	</tr>
</thead>

<tbody>
	<?php if ( ! empty( $list_document ) ) : ?>
		<?php foreach ( $list_document as $element ) : ?>
			<?php View_Util::exec( 'sheet_groupment', 'list-item', array( 'element' => $element ) ); ?>
		<?php endforeach; ?>
	<?php endif; ?>
</tbody>
