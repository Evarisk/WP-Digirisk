<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<ul class="wp-digi-list wp-digi-list-workunit" >
	<?php if ( !empty( $list_workunit ) ) : ?>
		<?php foreach ( $list_workunit as $element ) : ?>
			<?php require ( SOCIETY_VIEW_DIR . '/workunit/item.view.php' ); ?>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>
