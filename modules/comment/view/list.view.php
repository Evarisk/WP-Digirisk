<?php
/**
 * Affichage des commentaires
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
} ?>

<?php if ( ! empty( $comments ) ) : ?>
	<?php foreach ( $comments as $key => $comment ) : ?>
		<?php if ( 'edit' === $display ) : ?>
			<?php
			\eoxia\View_Util::exec( 'digirisk', 'comment', 'item-edit', array(
				'add_button'   => $add_button,
				'key'          => $key,
				'type'         => $type,
				'comment'      => $comment,
				'id'           => $id,
				'display_user' => $display_user,
				'display_date' => $display_date,
			) );
			?>
		<?php else : ?>
			<?php
			\eoxia\View_Util::exec( 'digirisk', 'comment', 'item', array(
				'key'          => $key,
				'type'         => $type,
				'comment'      => $comment,
				'id'           => $id,
				'display_user' => $display_user,
				'display_date' => $display_date,
			) );
			?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php else : ?>
	<?php if ( 'view' === $display ) : ?>
		<li><i><?php echo esc_html( 'Aucun commentaire', 'digirisk' ); ?></i></li>
	<?php endif; ?>
<?php endif; ?>
