<?php
/**
 * Edition d'un commentaire
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php
$author_id = ! empty( $comment->author_id ) ? $comment->author_id : get_current_user_id();

$user = User_Digi_Class::g()->get( array(
	'id' => $comment->author_id,
), true );
?>

<li class="<?php echo esc_attr( ( 0 !== $id && 0 === $comment->id ) ? 'new' : '' ); ?> comment">
	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][post_id]" value="<?php echo esc_attr( $id ); ?>" />
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][author_id]" value="<?php echo esc_attr( $author_id ); ?>" />
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][id]" value="<?php echo esc_attr( $comment->id ); ?>" />
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][parent_id]" value="<?php echo esc_attr( $comment->parent_id ); ?>" />

	<?php if ( $display_user ) : ?>
		<span class="user">
			<div class="avatar tooltip hover" aria-label="<?php echo esc_attr( $user->displayname ); ?>" style="background-color: #<?php echo esc_attr( $user->avatar_color ); ?>;">
				<span>
					<?php echo esc_html( $user->initial ); ?>
				</span>
			</div>
		</span>
	<?php endif; ?>

	<?php if ( $display_date ) : ?>
		<div class="group-date">
			<input type="text" class="mysql-date" style="width: 0px; padding: 0px; border: none;" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][date]" value="<?php echo esc_attr( $comment->date['date_input']['date'] ); ?>" />
			<input type="text" class="date" placeholder="04/01/2017" value="<?php echo esc_html( $comment->date['date_input']['fr_FR']['date'] ); ?>" />
		</div>
	<?php endif; ?>

	<textarea rows="1" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][content]" placeholder="Entrer un commentaire"><?php echo esc_html( $comment->content ); ?></textarea>

	<!-- Ajout d'un filtre permettant de rajouter des champs à la fin -->
	<?php apply_filters( 'digi_' . $type . '_edit_end', $comment ); ?>

	<?php if ( 0 !== $id && 0 !== $comment->id ) : ?>
		<span class="button delete action-delete"
					data-id="<?php echo esc_attr( $comment->id ); ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_comment_' . $comment->id ) ); ?>"
					data-action="delete_comment"
					data-message-delete="<?php echo esc_attr_e( 'Supprimer', 'digirisk' ); ?>"><i class="icon fa fa-times"></i></span>
	<?php else : ?>
		<?php if ( 0 !== $id && $add_button ) : ?>
			<span data-parent="comment"
						data-action="save_comment"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_comment' ) ); ?>"
						data-type="<?php echo esc_attr( $type ); ?>"
						data-namespace="<?php echo esc_attr( $namespace ); ?>"
						data-display="<?php echo esc_attr( $display ); ?>"
						data-id="<?php echo esc_attr( $id ); ?>"
						data-add-button="<?php echo esc_attr( $add_button ); ?>"
						data-display-date="<?php echo esc_attr( $display_date ); ?>"
						data-display-user="<?php echo esc_attr( $display_user ); ?>"
						class="button add action-input"><i class="icon fa fa-plus"></i></span>
		<?php endif; ?>
	<?php endif; ?>
</li>
