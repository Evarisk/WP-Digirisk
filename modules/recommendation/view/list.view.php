<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-table-header">
	<span class="wp-digi-recommendation-list-column-thumbnail" >&nbsp;</span>
	<span class="wp-digi-recommendation-list-column-reference" ><?php _e( 'Ref.', 'digirisk' ); ?></span>
	<span><?php _e( 'Préconisation', 'digirisk' ); ?></span>
	<span><?php _e( 'Commentaire', 'digirisk' ); ?></span>
	<span>&nbsp;</span>
	<span>&nbsp;</span>
</li>

<?php $i = 1; ?>
<?php if ( !empty( $recommendation_list ) ) : ?>
	<?php foreach ( $recommendation_list as $recommendation ) : ?>
		<?php view_util::exec( 'recommendation', 'list-item', array( 'recommendation' => $recommendation ) ); ?>
	<?php endforeach; ?>
<?php endif; ?>
