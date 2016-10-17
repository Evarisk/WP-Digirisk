<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<?php if ( !empty( $recommendation_category_list ) ) : ?>
	<input class="input-hidden-recommendation" type="hidden" name="taxonomy[digi-recommendation][]" value='<?php echo $first_recommendation->id; ?>' />
	<toggle class="wp-digi-summon-list" data-target="wp-digi-select-list">
		<span><?php echo wp_get_attachment_image( $first_recommendation->thumbnail_id, 'thumbnail', false, array( 'title' => $first_recommendation->name ) ); ?></span>
		<i class="dashicons dashicons-arrow-down"></i>
		<div class="wp-digi-select-list digi-popup grid icon hidden">
		<?php foreach( $recommendation_category_list as $recommendation_category ): ?>
			<ul>
				<?php if( !empty( $recommendation_category->recommendation_term ) ): ?>
					<?php foreach( $recommendation_category->recommendation_term as $recommendation ): ?>
						<li class="child" data-id="<?php echo $recommendation->id; ?>"><?php echo wp_get_attachment_image( $recommendation->thumbnail_id, 'thumbnail', false, array( 'title' => $recommendation->name ) ); ?></li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		<?php endforeach; ?>
		</div>
	</toggle>
<?php else: ?>
	<?php _e( 'There are no recommendation category to display here. Please create some danger category before.', 'digirisk' ); ?>
<?php endif; ?>
