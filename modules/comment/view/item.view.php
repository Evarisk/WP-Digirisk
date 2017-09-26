<?php
/**
 * Affichage d'un commentaire
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

$userdata = get_userdata( $comment->author_id ); ?>

<li class="comment">

	<?php if ( $display_user ) : ?>
		<span class="user"><?php echo ! empty( $userdata->display_name ) ? $userdata->display_name : 'Indéfini'; ?>, </span>
	<?php endif; ?>

	<?php if ( $display_date ) : ?>
		<span class="date"><?php echo $comment->date['date_input']['fr_FR']['date']; ?> : </span>
	<?php endif; ?>

	<span class="content"><?php echo $comment->content; ?></span>

	<span><?php apply_filters( 'digi_' . $type . '_view_end', $comment ); ?></span>
</li>
