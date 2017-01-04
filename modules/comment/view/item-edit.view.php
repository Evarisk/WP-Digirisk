<?php
/**
 * Edition d'un commentaire
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

<li class="new comment">
	<span class="user">Jean Louis, </span>
	<input type="text" class="date" placeholder="04/01/2017" />
	<input type="text" class="content" placeholder="Entrer un commentaire" />
	<span class="button add">
		<i class="icon fa fa-plus"></i>
	</span>
</li>
