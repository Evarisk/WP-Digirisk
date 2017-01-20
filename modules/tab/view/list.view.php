<?php
/**
 * Loop the list_tab for display it.
 * Each tab have an attribute data-action for javascript request.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package tab
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<ul class="tab">
	<?php
	if ( ! empty( $list_tab[ $type ] ) ) :
		foreach ( $list_tab[ $type ] as $key => $element ) :
			View_Util::exec( 'tab', 'item-' . $element['type'], array( 'display' => $display, 'id' => $id, 'key' => $key, 'element' => $element ) );
		endforeach;
	endif; ?>
</ul>
