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

<ul class="workunit-list">
	<?php if ( ! empty( $workunits ) ) : ?>
		<?php foreach ( $workunits as $workunit ) : ?>
			<?php view_util::exec( 'navigation', 'item', array( 'workunit_selected_id' => $workunit_selected_id, 'workunit' => $workunit ) ); ?>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>

<?php
if ( $display_create_workunit_form ) :
	view_util::exec( 'navigation', 'item-new', array( 'parent_id' => $parent_id ) );
endif;
?>
