<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-list-workunit" >
	<?php if ( !empty( $list_workunit ) ) : ?>
		<?php foreach ( $list_workunit as $element ) : ?>
			<?php view_util::exec( 'workunit', 'item', array( 'editable_identity' => $editable_identity, 'workunit_selected_id' => $workunit_selected_id, 'element' => $element ) ); ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php view_util::exec( 'workunit', 'item-new', array( 'groupment_id' => $groupment_id ) ); ?>
</ul>
