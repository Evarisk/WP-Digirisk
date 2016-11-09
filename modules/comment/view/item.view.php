<?php
namespace digi;
if ( !defined( 'ABSPATH' ) ) exit;
?>

<li>
	<?php
	$userdata = get_userdata( $comment->author_id );
	echo !empty( $userdata->display_name ) ? $userdata->display_name : 'Indéfini'; ?>
	<strong><?php echo $comment->date; ?></strong> :
	<?php echo $comment->content; ?>
</li>
