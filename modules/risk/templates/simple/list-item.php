<?php if ( !defined( 'ABSPATH' ) ) exit;

if ( $risk != null ):
?>
	<li class="wp-digi-list-item wp-digi-risk-item" data-risk-id="<?php echo $risk->id; ?>" >
		<span title="<?php _e( 'Upload media', 'wpdigi-i18n' ); ?>" class="wp-digi-element-thumbnail wp-digi-risk-thumbnail wpeo-upload-media" data-type="digi-risk" data-id="<?php echo $risk->id; ?>" >
			<div class="mask">
				<span class="dashicons dashicons-plus"></span>
			</div>
			<?php if ( has_post_thumbnail( $risk->id ) ) : ?>
				<?php echo get_the_post_thumbnail( $risk->id, 'digirisk-element-miniature' ); ?>
				<?php echo do_shortcode( "[wpeo_gallery element_id='" . $risk->id . "' global='wpdigi_risk_ctr' ]" ); ?>
			<?php else: ?>
				<i  title="<?php _e( 'Upload image', 'wpdigi-i18n' ); ?>" class="wp-digi-element-thumbnail wp-digi-risk-thumbnail dashicons dashicons-format-image" data-type="digi-risk" data-id="<?php echo $risk->id; ?>" ></i>
			<?php endif; ?>
		</span>
		<span class="wp-digi-risk-list-column-cotation" ><div class="wp-digi-risk-level-<?php echo $risk->evaluation->option[ 'risk_level' ][ 'scale' ]; ?>" >&nbsp;</div></span>
		<span class="wp-digi-risk-list-column-reference" ><?php echo $risk->option[ 'unique_identifier' ]; ?> - <?php echo $risk->evaluation->option[ 'unique_identifier' ]?></span>
		<span class="wp-digi-risk-list-column-danger"><?php echo wp_get_attachment_image( $risk->danger->option['thumbnail_id'], 'thumbnail', false, array( 'title' => $risk->danger->name ) ); ?></span>
		<span class="wp-digi-risk-comment" >
			<?php if ( !empty( $risk->comment ) ) : ?>
				<ul>
			<?php foreach ( $risk->comment as $comment ) : ?>
					<?php if ( $comment->status == '-34070' ): ?>
						<li>
							<?php
							$userdata = get_userdata( $comment->author_id );
							echo $userdata->display_name; ?>
							<strong><?php echo date( 'd/m/Y', strtotime( $comment->date ) ); ?></strong> :
							<?php echo $comment->content; ?>
							</li>
					<?php endif; ?>
			<?php endforeach; ?>

				</ul>
			<?php endif;?>
		</span>
		<span class="wp-digi-action wp-digi-risk-action" >
			<a href="#" data-id="<?php echo $risk->id; ?>" data-global="<?php echo str_replace( 'mdl_01', 'ctr',get_class( $element ) ); ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_load_risk_' . $risk->id ); ?>" class="wp-digi-action wp-digi-action-load dashicons dashicons-edit" ></a>
			<a href="#" data-id="<?php echo $risk->id; ?>" data-global="<?php echo str_replace( 'mdl_01', 'ctr',get_class( $element ) ); ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_risk_' . $risk->id ); ?>" class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
		</span>
	</li>
<?php endif ; ?>
