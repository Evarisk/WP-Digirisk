<?php if ( !defined( 'ABSPATH' ) ) exit;
if ( $risk != null ):
?>
	<form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="wp-digi-table-item-edit wp-digi-list-item wp-digi-risk-item form-risk" data-risk-id="<?php echo $risk_id; ?>">
		<?php wp_nonce_field( 'save_risk' ); ?>
		<input type="hidden" name="action" value="save_risk" />
		<input type="hidden" name="risk_id" value="<?php echo $risk_id; ?>" />

		<?php echo do_shortcode( '[eo_upload_button id="' . $risk_id . '" type="risk"]' ); ?>
		<?php echo do_shortcode( '[digi_evaluation_method risk_id=' . $risk_id . ']' ); ?>

		<span class="wp-digi-risk-list-column-reference" ><?php echo $risk->unique_identifier; ?> - <?php echo $risk->evaluation[0]->unique_identifier; ?></span>
		<span class="wp-digi-risk-list-column-danger"><?php echo wp_get_attachment_image( $risk->danger_category[0]->danger[0]->thumbnail_id, 'thumbnail', false, array( 'title' => $risk->danger_category[0]->danger[0]->name ) ); ?></span>
		<span class="wp-digi-risk-comment" >
			<ul>
				<?php if ( !empty( $risk->comment ) ) : ?>
					<?php foreach ( $risk->comment as $comment ) : ?>
						<?php if ( $comment->status == '-34070' ): ?>
							<li>
								<?php
								$userdata = get_userdata( $comment->author_id );
								echo !empty( $userdata->display_name ) ? $userdata->display_name : '';
								?>
								<input type="hidden" name="list_comment[<?php echo $comment->id; ?>][author_id]" value="<?php echo $comment->author_id; ?>" />
								<input type="hidden" name="list_comment[<?php echo $comment->id; ?>][comment_id]" value="<?php echo $comment->id; ?>" />
								<input type="text" class="wpdigi_date" name="list_comment[<?php echo $comment->id; ?>][comment_date]" value="<?php echo date( 'd/m/Y', strtotime( $comment->date ) ); ?>" /> : <input type="text" class="wpdigi_comment" name="list_comment[<?php echo $comment->id; ?>][comment_content]" value="<?php echo $comment->content; ?>" />
								<a href="#" data-id="<?php echo $comment->id; ?>" data-risk-id="<?php echo $risk_id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_risk_comment_' . $risk_id . '_' . $comment->id ); ?>" class="wp-digi-action wp-digi-action-comment-delete dashicons dashicons-no-alt" ></a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif;?>
				<!-- Ajouter un commentaire -->
				<li>
					<?php
					$userdata = get_userdata( get_current_user_id() );
					echo !empty( $userdata->display_name ) ? $userdata->display_name : '';
					?>
					<input type="text" class="wpdigi_date" name="list_comment[0][comment_date]" value="<?php echo date( 'd/m/Y' ); ?>" /> :
					<input type="text" class="wpdigi_comment" name="list_comment[0][comment_content]" value="" />
				</li>
			</ul>
		</span>
		<span class="wp-digi-action">
			<a href="#" data-id="<?php echo $risk_id; ?>" class="wp-digi-action wp-digi-action-edit fa fa-floppy-o" aria-hidden="true" ></a>
		</span>

		<?php echo do_shortcode( '[digi_evaluation_method_evarisk risk_id=' . $risk_id . ']' ); ?>

	</form>
<?php endif ; ?>
