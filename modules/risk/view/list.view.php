<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-risk wp-digi-table" >
	<li class="wp-digi-risk-list-header wp-digi-table-header" >
		<span class="wp-digi-risk-list-column-thumbnail" >&nbsp;</span>
		<span class="wp-digi-risk-list-column-cotation" ><i class="fa fa-line-chart" aria-hidden="true"></i></span>
		<span class="wp-digi-risk-list-column-reference header" ><?php _e( 'Ref.', 'digirisk' ); ?></span>
		<span><?php _e( 'Risque', 'digirisk' ); ?></span>
		<span><?php _e( 'Comment', 'digirisk' ); ?></span>
		<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
	</li>

	<?php $i = 1; ?>
	<?php if ( !empty( $risk_list ) ) : ?>
		<?php foreach ( $risk_list as $risk ) : ?>
			<?php require( RISK_VIEW_DIR . '/list-item.php' ); ?>
		<?php endforeach; ?>
	<?php endif; ?>

</ul>
