<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-list-workunit" >
	<?php if ( !empty( $list_workunit ) ) : ?>
		<?php foreach ( $list_workunit as $element ) : ?>
			<?php view_util::g()->exec( 'workunit', 'item' ); ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php view_util::g()->exec( 'workunit', 'item-new', array( 'groupment_id' => $groupment_id ) ); ?>
</ul>
