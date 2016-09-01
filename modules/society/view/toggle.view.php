<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<toggle class="wp-digi-summon-list navigation wp-digi-button-popup" data-target="wp-digi-develop-list">
	<?php do_shortcode( '[eo_upload_button id=' . $groupment->id . ' type=digi-group]' ); ?>
	<?php echo $groupment->unique_identifier . ' - <span>' . $groupment->title . '</span>'; ?><i class="dashicons dashicons-arrow-down"></i>
</toggle>
