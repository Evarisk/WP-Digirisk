<?php
/**
 * Affichage d'un commentaire
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

$user = User_Digi_Class::g()->get( array(
	'id' => $comment->data['author_id'],
), true ); ?>

<li class="comment">

	<?php if ( $display_user ) : ?>
		<span class="user">
			<div class="avatar tooltip hover" aria-label="<?php echo esc_attr( $user->data['displayname'] ); ?>" style="background-color: #<?php echo esc_attr( $user->data['avatar_color'] ); ?>;">
				<span>
					<?php echo esc_html( $user->data['initial'] ); ?>
				</span>
			</div>
		</span>
	<?php endif; ?>

	<?php if ( $display_date ) : ?>
		<span class="date"><?php echo esc_html( $comment->data['date']['rendered']['date'] ); ?> : </span>
	<?php endif; ?>

	<span class="content"><?php echo $comment->data['content']; ?></span>

	<span><?php apply_filters( 'digi_' . $type . '_view_end', $comment ); ?></span>
</li>
