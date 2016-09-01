<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wp-digi-group-header wp-digi-group-selector">
	<toggle class="wp-digi-summon-list navigation wp-digi-button-popup" data-target="wp-digi-develop-list">
		<?php do_shortcode( '[eo_upload_button id=' . $groupment->id . ' type=digi-group]' ); ?>
		<?php echo $groupment->unique_identifier . ' - <span>' . $groupment->title . '</span>'; ?><i class="dashicons dashicons-arrow-down"></i>
	</toggle>

	<div class="wp-digi-develop-list digi-popup hidden">
		<?php group_class::g()->display_list_item( $groupment ); ?>
	</div>
</div>
