<?php
/**
 * Le bouton (toggle) qui permet d'afficher le titre du groupement actuellement sélectionné.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package navigation
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="workunit-navigation toggle">
	<div class="unit-header">
		<?php do_shortcode( '[eo_upload_button id=' . $groupment->id . ' type=digi-group]' ); ?>
		<div class="title toggle" data-parent="workunit-navigation" data-target="content"><?php echo esc_html( $groupment->unique_identifier . ' - ' . $groupment->title ); ?></div>
		<span class="button w50 toggle" data-parent="workunit-navigation" data-target="content"><i class="icon fa fa-angle-down"></i></span>
	</div>

	<ul class="content">
		<?php Navigation_Class::g()->display_toggle_list( $groupment->id ); ?>
	</ul>
</div>
