<?php namespace digi;
if ( !defined( 'ABSPATH' ) ) exit; ?>

<li>
	<?php
	$userdata = get_userdata( $comment->author_id );
	echo !empty( $userdata->display_name ) ? $userdata->display_name : ''; ?>
	<strong><?php echo date( 'd/m/Y', strtotime( $comment->date ) ); ?></strong> :
	<?php echo $comment->content; ?>
</li>
