<?php
/**
 * Le bouton qui permet d'afficher la liste des groupements lors du clic sur celui-ci.
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<div class="wp-digi-group-header wp-digi-group-selector">
	<toggle class="wp-digi-summon-list navigation wp-digi-button-popup" data-target="wp-digi-develop-list">
		<?php do_shortcode( '[eo_upload_button id=' . $groupment->id . ' type=digi-group]' ); ?>
		<?php echo esc_html( $groupment->unique_identifier ); ?>
		<span class="title"> - <?php echo esc_html( $groupment->title ); ?></span>
		<i class="dashicons dashicons-arrow-down"></i>
	</toggle>

	<div class="wp-digi-develop-list digi-popup hidden">
		<?php Navigation_Class::g()->display_toggle_list( $groupment->id ); ?>
	</div>
</div>
