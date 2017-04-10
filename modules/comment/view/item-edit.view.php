<?php
/**
 * Edition d'un commentaire
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package comment
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
$author_id = ! empty( $comment->author_id ) ? $comment->author_id : get_current_user_id();
$userdata = get_userdata( $author_id );
?>

<li class="<?php echo esc_attr( ( 0 !== $id && 0 === $comment->id ) ? 'new' : '' ); ?> comment">
	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][post_id]" value="<?php echo esc_attr( $id ); ?>" />
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][author_id]" value="<?php echo esc_attr( $author_id ); ?>" />
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][id]" value="<?php echo esc_attr( $comment->id ); ?>" />

	<span class="user"><?php echo esc_html( $userdata->display_name ); ?>, </span>
	<input type="text" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][date]" class="date" placeholder="04/01/2017" value="<?php echo esc_html( $comment->date ); ?>" />
	<textarea rows="1" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][content]" placeholder="Entrer un commentaire"><?php echo esc_html( $comment->content ); ?></textarea>

	<!-- Ajout d'un filtre permettant de rajouter des champs à la fin -->
	<?php apply_filters( 'digi_' . $type . '_edit_end', $comment ); ?>

	<?php if ( 0 !== $id && 0 !== $comment->id ) : ?>
		<span class="button delete action-delete"
					data-id="<?php echo esc_attr( $comment->id ); ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_comment_' . $comment->id ) ); ?>"
					data-action="delete_comment"><i class="icon fa fa-times"></i></span>
	<?php else : ?>
		<?php if ( 0 !== $id && $add_button ) : ?>
			<span data-parent="comment"
						data-action="save_comment"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_comment' ) ); ?>"
						data-type="<?php echo esc_attr( $type ); ?>"
						class="button add action-input"><i class="icon fa fa-plus"></i></span>
		<?php endif; ?>
	<?php endif; ?>
</li>
