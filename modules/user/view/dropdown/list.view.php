<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<?php
if ( !empty( $list_user ) ):
	?>
	<select name="accident[<?php echo $element_id; ?>][user_id]">
	<?php
  foreach ( $list_user as $element ):
		require( USERS_VIEW . 'dropdown/list-item.view.php' );
  endforeach;
	?>
	</select>
	<?php
else:
	?><span><?php _e( 'Aucun utilisateur', 'digirisk'); ?></span><?php
endif;
?>
