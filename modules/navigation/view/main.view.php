<?php
/**
 * Vue principale de la navigation
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="navigation-container">
	<?php Navigation_Class::g()->display_toggle( $groupment_id ); ?>
	<?php Navigation_Class::g()->display_workunit_list( $groupment_id ); ?>
</div>
