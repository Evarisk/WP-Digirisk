<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-table wp-digi-recommendation" >
	<li class="wp-digi-table-header">
		<span class="wp-digi-recommendation-list-column-thumbnail" >&nbsp;</span>
		<span class="wp-digi-recommendation-list-column-reference" ><?php _e( 'Ref.', 'digirisk' ); ?></span>
		<span><?php _e( 'Recommendation name', 'digirisk' ); ?></span>
		<span><?php _e( 'Comment', 'digirisk' ); ?></span>
		<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
	</li>

	<?php $i = 1; ?>
	<?php if ( !empty( $recommendation_list ) ) : ?>
		<?php foreach ( $recommendation_list as $recommendation ) : ?>
			<?php view_util::exec( 'recommendation', 'list-item', array( 'recommendation' => $recommendation ) ); ?>
		<?php endforeach; ?>
	<?php endif; ?>
