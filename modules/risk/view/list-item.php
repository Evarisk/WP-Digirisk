<?php if ( !defined( 'ABSPATH' ) ) exit;

if ( $risk != null ):
?>
	<li class="wp-digi-list-item wp-digi-risk-item" data-risk-id="<?php echo $risk->id; ?>" >
		<?php echo do_shortcode( '[eo_upload_button id="' . $risk->id . '" type="risk"]' ); ?>
		<span class="wp-digi-risk-list-column-cotation" ><div class="wp-digi-risk-level-<?php echo $risk->evaluation[0]->scale; ?>" ><?php echo $risk->evaluation[0]->risk_level['equivalence']; ?></div></span>
		<span class="wp-digi-risk-list-column-reference" ><?php echo $risk->unique_identifier; ?> - <?php echo $risk->evaluation[0]->unique_identifier; ?></span>
		<span class="wp-digi-risk-list-column-danger"><?php echo wp_get_attachment_image( $risk->danger_category[0]->danger[0]->thumbnail_id, 'thumbnail', false, array( 'title' => $risk->danger_category[0]->danger[0]->name ) ); ?></span>
		<span class="wp-digi-risk-comment" >
			<?php if ( !empty( $risk->comment ) ) : ?>
				<ul>
			<?php foreach ( $risk->comment as $comment ) : ?>
					<?php if ( $comment->status == '-34070' ): ?>
						<li>
							<?php
							$userdata = get_userdata( $comment->author_id );
							echo !empty( $userdata->display_name ) ? $userdata->display_name : ''; ?>
							<strong><?php echo date( 'd/m/Y', strtotime( $comment->date ) ); ?></strong> :
							<?php echo $comment->content; ?>
							</li>
					<?php endif; ?>
			<?php endforeach; ?>

				</ul>
			<?php endif;?>
		</span>
		<span class="wp-digi-action wp-digi-risk-action" >
			<a href="#" data-id="<?php echo $risk->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_load_risk_' . $risk->id ); ?>" class="wp-digi-action wp-digi-action-load dashicons dashicons-edit" ></a>
			<a href="#" data-id="<?php echo $risk->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_risk_' . $risk->id ); ?>" class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
		</span>
	</li>
<?php endif ; ?>
