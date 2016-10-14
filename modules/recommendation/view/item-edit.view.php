<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<form method="post" class="wp-digi-list-item wp-digi-table-item-edit wp-digi-recommendation-item" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
	<input type="hidden" name="action" value="save_recommendation" />
	<input type="hidden" name="workunit_id" value="<?php echo $society_id; ?>" />
	<input type="hidden" name="term_id" value="<?php echo $recommendation->id; ?>" />
	<input type="hidden" name="index" value="<?php echo $index; ?>" />
	<?php do_shortcode( '[eo_upload_button id="' . $recommendation->id . '" type="recommendation"]' ); ?>
	<span class="wp-digi-recommendation-list-column-reference"><?php echo !empty( $recommendation->unique_identifier ) ? $recommendation->unique_identifier : 'PA0'; ?></span>
	<?php do_shortcode( '[dropdown_recommendation id="' . $recommendation->id . '" type="recommendation"]' ); ?>
	<span><?php echo $recommendation->name; ?></span>
	<span class="wp-digi-comment">Comment</span>
	<span class="wp-digi-action">
		<a href="#" data-workunit-id="<?php echo $society_id; ?>" data-id="<?php echo $recommendation->id; ?>; ?>" data-index="<?php echo $index; ?>" class="wp-digi-action-edit fa fa-floppy-o" aria-hidden="true"></a>
	</span>
</form>
