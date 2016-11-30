<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<span class="wp-digi-risk-list-column-danger">
	<?php echo wp_get_attachment_image( $risk->danger->thumbnail_id, 'thumbnail', false, array( 'title' => $risk->danger->name ) ); ?>
	<input class="input-hidden-danger" type="hidden" name="risk[danger_id]" value='<?php echo $risk->danger->id; ?>' />
</span>
