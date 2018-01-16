<?php
/**
 * Loop the list_tab for display it.
 * Each tab have an attribute data-action for javascript request.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul class="tab-list">
	<?php
	if ( ! empty( $list_tab[ $type ] ) ) :
		foreach ( $list_tab[ $type ] as $key => $element ) :
			\eoxia\View_Util::exec( 'digirisk', 'tab', 'item-' . $element['type'], array(
				'display' => $display,
				'id'      => $id,
				'key'     => $key,
				'element' => $element,
			) );
		endforeach;
	endif;
	?>
</ul>
