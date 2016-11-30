<?php
/**
 * La liste des unités de travail
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<ul class="wp-digi-list wp-digi-list-workunit" >
	<?php if ( ! empty( $workunits ) ) : ?>
		<?php foreach ( $workunits as $workunit ) : ?>
			<?php view_util::exec( 'navigation', 'item', array( 'workunit_selected_id' => $workunit_selected_id, 'workunit' => $workunit ) ); ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php view_util::exec( 'navigation', 'item-new', array( 'parent_id' => $parent_id ) ); ?>
</ul>
