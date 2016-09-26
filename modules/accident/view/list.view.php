<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-accident-list-header wp-digi-table-header">
	<span class="wp-digi-accident-list-column-id"><?php _e( 'ID', 'digirisk' ); ?></span>
	<span class="wp-digi-accident-list-column-name"><?php _e( 'Risque associé', 'digirisk' ); ?></span>
	<span class="wp-digi-accident-list-column-description"><?php _e( 'Date accident', 'digirisk' ); ?> </span>
	<span class="wp-digi-accident-list-column-serial-number"><?php _e('Personne accidentée', 'digirisk' ); ?></span>
	<span class="wp-digi-accident-list-column-fabrication-date"><?php _e('Description', 'digirisk'); ?></span>
	<span class="wp-digi-accident-list-column-shelf-life"><?php _e('Nb. de jour arrêt', 'digirisk'); ?></span>
	<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
</li>

<?php $i = 1; ?>
<?php if ( !empty( $accident_list ) ) : ?>
	<?php foreach ( $accident_list as $accident ) : ?>
		<?php require( ACCIDENT_VIEW_DIR . '/list-item.php' ); ?>
	<?php endforeach; ?>
<?php endif; ?>
