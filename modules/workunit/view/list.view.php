<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-list-workunit" >
	<?php if ( !empty( $list_workunit ) ) : ?>
		<?php foreach ( $list_workunit as $element ) : ?>
			<?php require ( WORKUNIT_VIEW_DIR . '/item.view.php' ); ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php require ( WORKUNIT_VIEW_DIR . '/item-new.view.php' ); ?>
</ul>
