<?php namespace digi;
if ( !defined( 'ABSPATH' ) ) exit; ?>

<?php if ( !empty( $element->comment ) ) : ?>
	<?php foreach ( $element->comment as $comment ) : ?>
		<?php if ( $comment->status == '-34070' ): ?>
			<?php if ( $display == 'edit' ): ?>
				<?php view_util::exec( 'comment', 'item-edit', array('type' => $type, 'comment' => $comment, 'element' => $element ) ); ?>
			<?php else: ?>
				<?php view_util::exec( 'comment', 'item', array('type' => $type, 'comment' => $comment, 'element' => $element ) ); ?>
			<?php endif; ?>
		<?php else: ?>
			<?php view_util::exec( 'comment', 'item-edit', array('type' => $type, 'comment' => $comment, 'element' => $element ) ); ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif;?>
