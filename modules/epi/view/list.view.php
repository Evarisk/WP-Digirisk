<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-epi-list-header wp-digi-table-header">
	<span class="wp-digi-epi-list-column-thumbnail" >&nbsp;</span>
	<span class="wp-digi-epi-list-column-id"><?php _e( 'ID', 'digirisk' ); ?></span>
	<span class="wp-digi-epi-list-column-name"><?php _e( 'nom', 'digirisk' ); ?></span>
	<span class="wp-digi-epi-list-column-description"><?php _e( 'descr.', 'digirisk' ); ?> </span>
	<span class="wp-digi-epi-list-column-serial-number"><?php _e('n° serie', 'digirisk' ); ?></span>
	<span class="wp-digi-epi-list-column-fabrication-date"><?php _e('date prod.', 'digirisk'); ?></span>
	<span class="wp-digi-epi-list-column-shelf-life"><?php _e('durée de vie', 'digirisk'); ?></span>

	<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
</li>

<?php $i = 1; ?>
<?php if ( !empty( $epi_list ) ) : ?>
	<?php foreach ( $epi_list as $epi ) : ?>
		<?php require( EPI_VIEW_DIR . '/list-item.php' ); ?>
	<?php endforeach; ?>
<?php endif; ?>
