<?php if ( !defined( 'ABSPATH' ) ) exit;
if ( $risk_definition != null ):
?>
	<form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="wp-digi-table-item-edit wp-digi-list-item wp-digi-risk-item form-risk" data-risk-id="<?php echo $risk_id; ?>">
		<?php wp_nonce_field( 'save_risk' ); ?>
		<input type="hidden" name="action" value="save_risk" />
		<input type="hidden" name="risk_id" value="<?php echo $risk_id; ?>" />
		<input type="hidden" name="global" value="<?php echo str_replace( 'mdl_01', 'ctr',get_class( $element ) ); ?>" />
		<input type="hidden" name="element_id" value="<?php echo $element->id; ?>" />

		<?php echo do_shortcode( '[eo_upload_button id="' . $risk_id . '" object_name="wpdigi_risk_ctr"]' ); ?>
		<?php do_shortcode( '[digi_evaluation_method risk_id=' . $risk_id . ']' ); ?>

		<span class="wp-digi-risk-list-column-reference" ><?php echo $risk_definition->option[ 'unique_identifier' ]; ?> - <?php echo $risk_definition->evaluation->option[ 'unique_identifier' ]?></span>
		<span class="wp-digi-risk-list-column-danger"><?php echo wp_get_attachment_image( $risk_definition->danger->option['thumbnail_id'], 'thumbnail', false, array( 'title' => $risk_definition->danger->name ) ); ?></span>
		<span class="wp-digi-risk-comment" >
			<ul>
				<?php if ( !empty( $risk_definition->comment ) ) : ?>
					<?php foreach ( $risk_definition->comment as $comment ) : ?>
						<?php if ( $comment->status == '-34070' ): ?>
							<li>
								<?php
								$userdata = get_userdata( $comment->author_id );
								echo $userdata->display_name;
								?>
								<input type="text" class="wpdigi_date" name="list_comment[<?php echo $comment->id; ?>][comment_date]" value="<?php echo date( 'd/m/Y', strtotime( $comment->date ) ); ?>" /> : <input type="text" class="wpdigi_comment" name="list_comment[<?php echo $comment->id; ?>][comment_content]" value="<?php echo $comment->content; ?>" />
								<a href="#" data-id="<?php echo $comment->id; ?>" data-risk-id="<?php echo $risk_id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_risk_comment_' . $risk_id . '_' . $comment->id ); ?>" class="wp-digi-action wp-digi-action-comment-delete dashicons dashicons-no-alt" ></a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif;?>
				<!-- Ajouter un commentaire -->
				<li><input type="text" class="wpdigi_date" name="comment_date" value="<?php echo date( 'd/m/Y' ); ?>" /> : <input type="text" class="wpdigi_comment" name="comment_content" value="" /></li>
			</ul>
		</span>
		<span class="wp-digi-action">
			<a href="#" data-id="<?php echo $risk_id; ?>" class="wp-digi-action wp-digi-action-edit dashicons dashicons-edit" ></a>
		</span>

		<?php do_shortcode( '[digi_evaluation_method_complex risk_id=' . $risk_id . ']' ); ?>

	</form>
<?php endif ; ?>
