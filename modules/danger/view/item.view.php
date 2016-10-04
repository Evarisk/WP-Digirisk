<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<span class="wp-digi-risk-list-column-danger">
	<?php echo wp_get_attachment_image( $risk->danger_category[0]->danger[0]->thumbnail_id, 'thumbnail', false, array( 'title' => $risk->danger_category[0]->danger[0]->name ) ); ?>
	<input class="input-hidden-danger" type="hidden" name="risk[<?php echo $id; ?>][danger_id]" value='<?php echo $risk->danger_category[0]->danger[0]->id; ?>' />
</span>
