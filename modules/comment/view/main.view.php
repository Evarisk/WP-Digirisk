<?php
/**
 * Affichage principale pour les commentaires
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

<ul class="comment-container">
	<?php View_Util::exec( 'comment', 'item-edit', array( 'comment' => $comment_new ) ); ?>
</ul>
