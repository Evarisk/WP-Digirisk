<?php
/**
 * Vue principale de la navigation.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="navigation-container">
	<?php
	\eoxia\View_Util::exec( 'digirisk', 'navigation', 'header', array(
		'society' => $society,
	) );

	\eoxia\View_Util::exec( 'digirisk', 'navigation', 'list', array(
		'selected_society_id' => $selected_society_id,
		'societies'           => $societies,
		'id'                  => $society->data['id'],
		'class'               => 'workunit-list',
	) );
	?>
</div>
