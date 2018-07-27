<?php
/**
 * Vue principale de la navigation.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="navigation-container">
	<?php
	\eoxia001\View_Util::exec( 'digirisk', 'navigation', 'header', array(
		'society' => $society,
	) );

	\eoxia001\View_Util::exec( 'digirisk', 'navigation', 'list', array(
		'selected_establishment_id' => $selected_establishment_id,
		'establishments' => $establishments,
		'id' => $society->id,
		'class' => 'workunit-list',
	) );
	?>
</div>
