<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<?php
if ( !empty( $society->list_risk ) ):
	?>
	<select name="accident[<?php echo $element_id; ?>][risk_id]">
	<?php
  foreach ( $society->list_risk as $element ):
		require( RISK_VIEW_DIR . 'dropdown/list-item.view.php' );
  endforeach;
	?>
	</select>
	<?php
else:
	?><span><?php _e( 'Aucun risque', 'digirisk'); ?></span><?php
endif;
?>
