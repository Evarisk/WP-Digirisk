<?php
/**
 * Edition d'un commentaire
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$user = User_Class::g()->get( array(
	'id'      => $comment->data['author_id'],
	'blog_id' => 0,
), true );

?>

<li class="<?php echo esc_attr( ( 0 !== $id && 0 === $comment->data['id'] ) ? 'new' : '' ); ?> comment">
	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->data['id'] ); ?>][post_id]" value="<?php echo esc_attr( $id ); ?>" />
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->data['id'] ); ?>][author_id]" value="<?php echo esc_attr( $comment->data['author_id'] ); ?>" />
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->data['id'] ); ?>][id]" value="<?php echo esc_attr( $comment->data['id'] ); ?>" />
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->data['id'] ); ?>][parent_id]" value="<?php echo esc_attr( $comment->data['parent_id'] ); ?>" />

	<?php if ( $display_user ) : ?>
		<span class="user">
			<div class="avatar tooltip hover" aria-label="<?php echo esc_attr( $user->data['displayname'] ); ?>" style="background-color: #<?php echo esc_attr( $user->data['avatar_color'] ); ?>;">
				<span>
					<?php
					if ( ! empty( $user->data['initial'] ) ) :
						echo esc_html( $user->data['initial'] );
					else:
						esc_html_e( 'N/A', 'digirisk' );
					endif;
					?>
				</span>
			</div>
		</span>
	<?php endif; ?>

	<?php if ( $display_date ) : ?>
		<div class="group-date">
			<input type="text" class="mysql-date" style="width: 0px; padding: 0px; border: none;" name="list_comment[<?php echo esc_attr( $comment->data['id'] ); ?>][date]" value="<?php echo esc_attr( $comment->data['date']['raw'] ); ?>" />
			<input type="text" class="date" placeholder="04/01/2017" value="<?php echo esc_html( $comment->data['date']['rendered']['date'] ); ?>" />
		</div>
	<?php endif; ?>

	<textarea rows="1" name="list_comment[<?php echo esc_attr( $comment->data['id'] ); ?>][content]" placeholder="Entrer un commentaire"><?php echo esc_html( $comment->data['content'] ); ?></textarea>

	<!-- Ajout d'un filtre permettant de rajouter des champs à la fin -->
	<?php apply_filters( 'digi_' . $type . '_edit_end', $comment ); ?>

	<?php if ( 0 !== $id && 0 !== $comment->data['id'] ) : ?>
		<span class="wpeo-button button-square-30 button-grey button-rounded delete action-delete"
					data-id="<?php echo esc_attr( $comment->data['id'] ); ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_comment' ) ); ?>"
					data-type="<?php echo esc_attr( $type ); ?>"
					data-namespace="digi"
					data-action="delete_comment"
					data-message-delete="<?php echo esc_attr_e( 'Êtes-vous sûr(e) de vouloir supprimer ce commentaire ?', 'digirisk' ); ?>"><i class="button-icon fas fa-times"></i></span>
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
						class="wpeo-button button-square-30 button-main button-rounded add action-input"><i class="button-icon fas fa-plus"></i></span>
		<?php endif; ?>
	<?php endif; ?>
</li>
