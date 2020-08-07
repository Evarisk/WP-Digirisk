<?php
/**
 * Ouvres une liste à puce, puis appel la vue item.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2019 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<ul>
	<?php
	if ( ! empty( $list_accronym ) ) :
		foreach ( $list_accronym as $key => $element ) :
			\eoxia\View_Util::exec( 'digirisk', 'setting', 'accronym/item', array(
				'key'     => $key,
				'element' => $element,
			) );
		endforeach;
	endif;
	?>
</ul>
