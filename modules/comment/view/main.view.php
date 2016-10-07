<?php
namespace digi;
if ( !defined( 'ABSPATH' ) ) exit;
?>

<span class="wp-digi-<?php echo $type; ?>-comment" >
	<ul>
		<?php view_util::exec( 'comment', 'list', array( 'element' => $element, 'display' => $display, 'type' => $type ) ); ?>
	</ul>
</span>
