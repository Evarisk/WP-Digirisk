<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-risk wp-digi-table" >
	<li class="wp-digi-risk-list-header wp-digi-table-header">
		<span class="wp-digi-risk-list-column-thumbnail" >&nbsp;</span>
		<span><?php _e( 'Ref.', 'digirisk' ); ?></span>
		<span><?php _e( 'Risque associé', 'digirisk' ); ?></span>
		<span><?php _e( 'Date accident', 'digirisk' ); ?> </span>
		<span><?php _e('Personne accidentée', 'digirisk' ); ?></span>
		<span><?php _e('Description', 'digirisk'); ?></span>
		<span><?php _e('Nb. de jour arrêt', 'digirisk'); ?></span>
		<span><?php _e('Enquête accident', 'digirisk'); ?></span>
		<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
	</li>

	<?php $i = 1; ?>
	<?php if ( !empty( $risk_list ) ) : ?>
		<?php foreach ( $risk_list as $risk ) : ?>
			<?php require( RISK_VIEW_DIR . '/list-item.php' ); ?>
		<?php endforeach; ?>
	<?php endif; ?>

</ul>
