<?php
namespace digi;
if ( !defined( 'ABSPATH' ) ) exit;
?>

<span class="wp-digi-<?php echo $type; ?>-comment" >
	<ul>
		<?php view_util::exec( 'comment', 'list', array( 'id' => $id, 'comment_new' => $comment_new, 'comments' => $comments, 'display' => $display, 'type' => $type ) ); ?>
	</ul>
</span>
