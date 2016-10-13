<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-list-item wp-digi-risk-item <?php echo empty ( $risk->id ) ? 'wp-digi-risk-item-new': ''; ?>" data-risk-id="<?php echo $risk->id; ?>">
	<input type="hidden" name="action" value="edit_risk" />
	<input type="hidden" name="parent_id" value="<?php echo $society_id; ?>" />
	<input name="risk[<?php echo $risk->id; ?>][id]" type="hidden" value="<?php echo $risk->id; ?>" />
	<?php do_shortcode( '[eo_upload_button id="' . $risk->id . '" type="risk"]' ); ?>
	<?php do_shortcode( '[digi_evaluation_method risk_id=' . $risk->id . ']' ); ?>
	<span class="wp-digi-risk-list-column-reference" ><?php echo $risk->unique_identifier; ?> - <?php echo $risk->evaluation[0]->unique_identifier; ?></span>
	<?php do_shortcode( '[dropdown_danger id="' . $risk->id . '" type="risk" display="' . (($risk->id != 0) ? "view" : "edit") . '"]' ); ?>
	<?php do_shortcode( '[digi_comment id="' . $risk->id . '" type="risk" display="edit"]'); ?>

	<span class="wp-digi-action">
		<a href="#" data-id="<?php echo $risk->id; ?>" class="wp-digi-action wp-digi-action-edit fa fa-floppy-o" aria-hidden="true" ></a>
	</span>

	<?php echo do_shortcode( '[digi_evaluation_method_evarisk risk_id=' . $risk->id . ' type="risk"]' ); ?>
</li>
