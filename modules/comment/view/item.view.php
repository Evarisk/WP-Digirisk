<?php
/**
 * Affichage d'un commentaire
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$user = User_Digi_Class::g()->get( array(
	'id' => $comment->author_id,
), true ); ?>

<li class="comment">

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
		<span class="date"><?php echo esc_html( $comment->date['rendered']['date'] ); ?> : </span>
	<?php endif; ?>

	<span class="content"><?php echo $comment->content; ?></span>

	<span><?php apply_filters( 'digi_' . $type . '_view_end', $comment ); ?></span>
</li>
