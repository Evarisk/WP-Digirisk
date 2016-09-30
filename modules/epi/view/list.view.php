<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-epi-list-header wp-digi-table-header">
	<span class="wp-digi-epi-list-column-thumbnail" >&nbsp;</span>
	<span class="wp-digi-epi-list-column-id"><?php _e( 'ID', 'digirisk' ); ?></span>
	<span class="wp-digi-epi-list-column-name"><?php _e( 'Nom', 'digirisk' ); ?></span>
	<span class="wp-digi-epi-list-column-serial-number"><?php _e('N° serie', 'digirisk' ); ?></span>
	<span class="wp-digi-epi-list-column-fabrication-date"><?php _e('Périod. de contrôle', 'digirisk'); ?></span>
	<span class="wp-digi-epi-list-column-shelf-life"><?php _e('Date de dernier contrôle', 'digirisk'); ?></span>
	<span class="wp-digi-epi-list-column-shelf-life"><?php _e('Reste', 'digirisk'); ?></span>
	<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
</li>

<?php $i = 1; ?>
<?php if ( !empty( $epi_list ) ) : ?>
	<?php foreach ( $epi_list as $epi ) : ?>
		<?php require( EPI_VIEW_DIR . '/list-item.php' ); ?>
	<?php endforeach; ?>
<?php endif; ?>
