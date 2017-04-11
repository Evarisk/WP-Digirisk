<?php
/**
 * Affichage des commentaires
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

<?php if ( ! empty( $comments ) && 0 !== $comments[0]->id ) : ?>
	<?php foreach ( $comments as $key => $comment ) : ?>
		<?php if ( '-34070' === $comment->status ) : ?>
			<?php if ( 'edit' === $display ) : ?>
				<?php view_util::exec( 'comment', 'item-edit', array( 'add_button' => $add_button, 'key' => $key, 'type' => $type, 'comment' => $comment, 'id' => $id ) ); ?>
			<?php else : ?>
				<?php view_util::exec( 'comment', 'item', array( 'key' => $key, 'type' => $type, 'comment' => $comment, 'id' => $id ) ); ?>
			<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php else : ?>
	<?php if ( 'view' === $display ) : ?>
		<li><i><?php echo esc_html( 'Aucun commentaire', 'digirisk' ); ?></i></li>
	<?php endif; ?>
<?php endif; ?>
