<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-risk wp-digi-table" >
	<li class="wp-digi-risk-list-header wp-digi-table-header">
		<span class="wp-digi-risk-list-column-thumbnail" >&nbsp;</span>
		<span class="wp-digi-risk-list-column-id"><?php _e( 'ID', 'digirisk' ); ?></span>
		<span class="wp-digi-risk-list-column-name"><?php _e( 'nom', 'digirisk' ); ?></span>
		<span class="wp-digi-risk-list-column-description"><?php _e( 'descr.', 'digirisk' ); ?> </span>
		<span class="wp-digi-risk-list-column-serial-number"><?php _e('n° serie', 'digirisk' ); ?></span>
		<span class="wp-digi-risk-list-column-fabrication-date"><?php _e('date prod.', 'digirisk'); ?></span>
		<span class="wp-digi-risk-list-column-shelf-life"><?php _e('durée de vie', 'digirisk'); ?></span>
		<span class="wp-digi-risk-list-column-periodicity-of-controls"><?php _e('per. de contrôles', 'digirisk'); ?></span>

		<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
	</li>

	<?php $i = 1; ?>
	<?php if ( !empty( $risk_list ) ) : ?>
		<?php foreach ( $risk_list as $risk ) : ?>
			<?php require( EPI_VIEW_DIR . '/list-item.php' ); ?>
		<?php endforeach; ?>
	<?php endif; ?>

</ul>
