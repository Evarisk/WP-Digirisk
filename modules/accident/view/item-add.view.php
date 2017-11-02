<?php
/**
 * Edition d'un accident
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="accident-row add">
	<div 	data-loader="table"
				data-parent="risk-row"
				class="button w50 blue add"><i class="icon fa fa-plus"></i></div>

	<?php
	\eoxia\View_Util::exec( 'digirisk', 'accident', 'item-edit', array(
		'main_society' => $main_society,
		'accident' => $accident,
	) );
	?>
</div>
