<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-table wp-digi-recommendation" >
	<li class="wp-digi-table-header" >
		<span class="wp-digi-recommendation-list-column-thumbnail" >&nbsp;</span>
		<span class="wp-digi-recommendation-list-column-reference" ><?php _e( 'Ref.', 'digirisk' ); ?></span>
		<span><?php _e( 'Recommendation name', 'digirisk' ); ?></span>
		<span><?php _e( 'Comment', 'digirisk' ); ?></span>
		<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
	</li>

	<?php if ( !empty( $list_recommendation_in_workunit ) ): ?>
		<?php foreach ( $list_recommendation_in_workunit as $term_id => $sub_array ): ?>
			<?php $term = recommendation_class::g()->get( array( 'id' => $term_id ) );
			$term = $term[0]; ?>
			<?php if ( !empty( $sub_array ) ): ?>
				<?php foreach( $sub_array as $index => $recommendation_in_workunit ):?>
					<?php if ( !empty( $recommendation_in_workunit['status'] ) && $recommendation_in_workunit['status'] == 'valid' ): ?>
						<?php require ( DIGI_RECOM_TEMPLATES_MAIN_DIR . '/list-item.php' ); ?>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>

<!-- Ajouter une nouvelle recommendation -->
<div class="wp-digi-recommendation-item wp-digi-recommendation-item-new">
	<form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
		<ul class="wp-digi-table">
			<li>
				<input type="hidden" name="action" value="wpdigi-create-recommendation" />
				<?php wp_nonce_field( 'ajax_create_recommendation' ); ?>
				<input type="hidden" name="workunit_id" value="<?php echo $element->id; ?>" />
				<span class="wp-digi-recommendation-thumbnail" >
					<i class="wp-digi-element-thumbnail dashicons dashicons-format-image" ></i>
					<img width="50" height="50" class="hidden attachment-digirisk-element-miniature size-digirisk-element-miniature wp-post-image" alt="" sizes="(max-width: 50px) 100vw, 50px">
				</span>
				<span class="wp-digi-recommendation-select">
					<?php if ( !empty( $list_recommendation_category ) ) : ?>
						<input type="hidden" name="recommendation_id" />
						<toggle data-target="wp-digi-select-list" class="wp-digi-summon-list"><?php _e( 'Select a recommendation', 'digirisk' ); ?> <i class="dashicons dashicons-arrow-down"></i></toggle>
						<div class="wp-digi-select-list digi-popup hidden grid icon">
							<?php foreach( $list_recommendation_category as $recommendation_category ): ?>
								<ul>
									<?php $list_recommendation = recommendation_class::g()->get( array( 'parent' => $recommendation_category->id, 'hide_empty' => false, ) );?>
									<?php if ( !empty( $list_recommendation ) ): ?>
										<?php foreach( $list_recommendation as $recommendation ): ?>
											<?php $attachement_url = wp_get_attachment_image_src( $recommendation->thumbnail_id ); ?>
											<li data-name="<?php echo $recommendation->name; ?>" data-url="<?php echo $attachement_url[0]; ?>" data-id="<?php echo $recommendation->id; ?>"><?php echo wp_get_attachment_image( $recommendation->thumbnail_id, 'thumbnail', false, array('title' => $recommendation->name) ); ?></li>
										<?php endforeach; ?>
									<?php endif ?>
								</ul>
							<?php endforeach; ?>
						</div>
					<?php else: ?>
						<?php _e( 'There are no recommendation category to display here. Please create some recommendation category before.', 'digirisk' ); ?>
					<?php endif; ?>
				</span>
				<span class="wp-digi-comment"><input type="text" name="recommendation_comment" placeholder="<?php _e( 'Enter a comment', 'digirisk' ); ?>" /></span>
				<span class="wp-digi-recommendation-action wp-digi-action-new wp-digi-action" ><a href="#" class="wp-digi-action dashicons dashicons-plus" ></a></span>
			</li>
		</ul>
	</form>
</div>
