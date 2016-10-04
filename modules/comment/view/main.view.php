<?php namespace digi;
if ( !defined( 'ABSPATH' ) ) exit; ?>

<span class="wp-digi-<?php echo $type; ?>-comment" >
	<ul>
		<?php if ( !empty( $element->comment ) ) : ?>
			<?php foreach ( $element->comment as $comment ) : ?>
				<?php if ( $comment->status == '-34070' ): ?>
					<li>
						<?php
						$userdata = get_userdata( $comment->author_id );
						echo !empty( $userdata->display_name ) ? $userdata->display_name : '';
						?>
						<input type="hidden" name="<?php echo $type; ?>[<?php echo $element->id ?>][list_comment][<?php echo $comment->id; ?>][author_id]" value="<?php echo $comment->author_id; ?>" />
						<input type="hidden" name="<?php echo $type; ?>[<?php echo $element->id ?>][list_comment][<?php echo $comment->id; ?>][id]" value="<?php echo $comment->id; ?>" />
						<input type="text" class="wpdigi_date" name="<?php echo $type; ?>[<?php echo $element->id ?>][list_comment][<?php echo $comment->id; ?>][date]" value="<?php echo date( 'd/m/Y', strtotime( $comment->date ) ); ?>" /> :
						<input type="text" class="wpdigi_comment" name="<?php echo $type; ?>[<?php echo $element->id ?>][list_comment][<?php echo $comment->id; ?>][content]" value="<?php echo $comment->content; ?>" />
						<a href="#" data-id="<?php echo $comment->id; ?>" data-<?php echo $type; ?>-id="<?php echo $element->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_risk_comment_' . $element->id . '_' . $comment->id ); ?>" class="wp-digi-action wp-digi-action-comment-delete dashicons dashicons-no-alt" ></a>
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
			<input type="hidden" name="<?php echo $type; ?>[<?php echo $element->id ?>][list_comment][<?php echo $comment_schema->id; ?>][author_id]" value="<?php echo $comment_schema->author_id; ?>" />
			<input type="hidden" name="<?php echo $type; ?>[<?php echo $element->id ?>][list_comment][<?php echo $comment_schema->id; ?>][id]" value="<?php echo $comment_schema->id; ?>" />
			<input type="text" class="wpdigi_date" name="<?php echo $type; ?>[<?php echo $element->id ?>][list_comment][0][date]" value="<?php echo $comment_schema->date; ?>" /> :
			<input type="text" class="wpdigi_comment" name="<?php echo $type; ?>[<?php echo $element->id ?>][list_comment][0][content]" value="<?php echo $comment_schema->content; ?>" />
		</li>
	</ul>
</span>
