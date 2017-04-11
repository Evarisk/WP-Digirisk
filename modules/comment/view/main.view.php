<?php
/**
 * Affichage principale pour les commentaires
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package comment
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<ul class="comment-container">
	<?php View_Util::exec( 'comment', 'list', array( 'id' => $id, 'add_button' => $add_button, 'comment_new' => $comment_new, 'comments' => $comments, 'display' => $display, 'type' => $type ) ); ?>

	<?php
	if ( 'edit' === $display ) :
		View_Util::exec( 'comment', 'item-edit', array( 'id' => $id, 'add_button' => $add_button, 'comment' => $comment_new, 'type' => $type ) );
	endif;
	?>
</ul>
