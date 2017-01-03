<?php
/**
 * Le bouton qui permet d'afficher la liste des groupements lors du clic sur celui-ci.
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<div class="workunit-navigation">
	<div class="unit-header">
		<?php do_shortcode( '[eo_upload_button id=' . $groupment->id . ' type=digi-group]' ); ?>
		<div class="title"><?php echo esc_html( $groupment->unique_identifier . ' - ' . $groupment->title ); ?></div>
		<span class="toggle button w50"><i class="icon fa fa-angle-down"></i></span>
	</div>
</div>
