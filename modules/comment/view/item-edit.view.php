<?php
namespace digi;
if ( !defined( 'ABSPATH' ) ) exit;
?>

<li>
	<?php
	$userdata = get_userdata( get_current_user_id() );
	echo !empty( $userdata->display_name ) ? $userdata->display_name : '';
	?>
	<input type="hidden" name="list_comment[<?php echo $comment->id; ?>][author_id]" value="<?php echo $comment->author_id; ?>" />
	<input type="hidden" name="list_comment[<?php echo $comment->id; ?>][id]" value="<?php echo $comment->id; ?>" />
	<input type="text" class="wpdigi_date" name="list_comment[<?php echo $comment->id; ?>][date]" value="<?php echo $comment->date; ?>" /> :
	<input type="text" class="wpdigi_comment" name="list_comment[<?php echo $comment->id; ?>][content]" value="<?php echo $comment->content; ?>" />
	<a href="#"
		data-id="<?php echo $comment->id; ?>"
		data-nonce="<?php echo wp_create_nonce( 'ajax_delete_comment_' . $comment->id ); ?>"
		data-action="delete_comment"
		class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
</li>
