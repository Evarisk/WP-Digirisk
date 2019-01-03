<?php
/**
 * Affichage principale pour les commentaires
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul class="comment-container">
	<?php
	\eoxia\View_Util::exec( 'digirisk', 'comment', 'list', array(
		'id' => $id,
		'add_button' => $add_button,
		'comment_new' => $comment_new,
		'comments' => $comments,
		'display' => $display,
		'type' => $type,
		'namespace' => $namespace,
		'display_date' => $display_date,
		'display_user' => $display_user,
	) );
	?>

	<?php
	if ( 'edit' === $display ) :
		\eoxia\View_Util::exec( 'digirisk', 'comment', 'item-edit', array(
			'id' => $id,
			'add_button' => $add_button,
			'comment' => $comment_new,
			'type' => $type,
			'namespace' => $namespace,
			'display' => $display,
			'display_date' => $display_date,
			'display_user' => $display_user,
		) );
	endif;
	?>
</ul>
