<?php
namespace digi;
if ( !defined( 'ABSPATH' ) ) exit;
?>

<?php if ( !empty( $element->comment ) ) : ?>
	<?php foreach ( $element->comment as $key => $comment ) : ?>
		<?php if ( $comment->status == '-34070' ): ?>
			<?php if ( $display == 'edit' ): ?>
				<?php view_util::exec( 'comment', 'item-edit', array('key' => $key, 'type' => $type, 'comment' => $comment, 'element' => $element ) ); ?>
			<?php else: ?>
				<?php view_util::exec( 'comment', 'item', array('key' => $key, 'type' => $type, 'comment' => $comment, 'element' => $element ) ); ?>
			<?php endif; ?>
		<?php elseif ( $element->id == 0 ): ?>
			<?php view_util::exec( 'comment', 'item-edit', array('key' => $key, 'type' => $type, 'comment' => $comment, 'element' => $element ) ); ?>
		<?php elseif ( $element->id > 0 && $display == 'edit' ): ?>
		<?php else: ?>
			<?php _e( '<span>Aucun commentaire</span>', 'digirisk' ); ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif;?>

<?php if ($element->id > 0 && $display == 'edit'): ?>
	<?php view_util::exec( 'comment', 'item-edit', array('key' => 0, 'type' => $type, 'comment' => $comment_new, 'element' => $element ) ); ?>
<?php endif; ?>
