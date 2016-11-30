<?php
namespace digi;
if ( !defined( 'ABSPATH' ) ) exit;
?>

<?php if ( !empty( $comments ) ) : ?>
	<?php foreach ( $comments as $key => $comment ) : ?>
		<?php if ( $comment->status == '-34070' ): ?>
			<?php if ( $display == 'edit' ): ?>
				<?php view_util::exec( 'comment', 'item-edit', array( 'key' => $key, 'type' => $type, 'comment' => $comment, 'id' => $id ) ); ?>
			<?php else: ?>
				<?php view_util::exec( 'comment', 'item', array( 'key' => $key, 'type' => $type, 'comment' => $comment, 'id' => $id ) ); ?>
			<?php endif; ?>
		<?php elseif ( $id == 0 ): ?>
			<?php view_util::exec( 'comment', 'item-edit', array( 'key' => $key, 'type' => $type, 'comment' => $comment, 'id' => $id ) ); ?>
		<?php elseif ( $id > 0 && $display == 'edit' ): ?>
		<?php else: ?>
			<?php _e( '<span>Aucun commentaire</span>', 'digirisk' ); ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif;?>

<?php if ( $id > 0 && $display == 'edit'): ?>
	<?php view_util::exec( 'comment', 'item-edit', array('key' => 0, 'type' => $type, 'comment' => $comment_new, 'id' => $id ) ); ?>
<?php endif; ?>
