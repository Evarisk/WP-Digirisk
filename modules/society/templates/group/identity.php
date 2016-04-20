<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<span class="wp-digi-group-name wp-digi-global-name">
	<strong><?php echo $group->option[ 'unique_identifier' ]; ?> -</strong>
	<input type="text" value="<?php echo $group->title; ?>" name="wp-digi-group-name" class="wp-digi-input-editable" />
	<input type="hidden" name="wp-digi-group-id" value="0" />
	<input type="text" data-id="<?php echo $group->id; ?>" class="wpdigi-auto-complete" />
</span>
