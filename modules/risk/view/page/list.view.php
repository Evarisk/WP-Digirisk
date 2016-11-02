<?php namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<li class="wp-digi-risk-list-header wp-digi-table-header" >
	<span>Groupement</span>
	<span>Unité de travail</span>
	<span class="wp-digi-risk-list-column-thumbnail">&nbsp;</span>
	<span class="wp-digi-risk-list-column-cotation"><a href="<?php echo esc_url( admin_url( 'admin.php?page=digirisk-handle-risk' ) . $url_ref_order ); ?>"><i class="fa fa-line-chart" aria-hidden="true"></i></a></span>
	<span class="wp-digi-risk-list-column-reference header"><?php _e( 'Ref.', 'digirisk' ); ?></span>
	<span><?php _e( 'Risque', 'digirisk' ); ?></span>
	<span><?php _e( 'Comment', 'digirisk' ); ?></span>
	<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
</li>

<?php $i = 1; ?>
<?php if ( ! empty( $risk_list ) ) : ?>
	<?php foreach ( $risk_list as $risk ) : ?>
		<?php view_util::exec( 'risk', 'page/item-edit', array( 'risk' => $risk ) ); ?>
	<?php endforeach; ?>
<?php endif; ?>
