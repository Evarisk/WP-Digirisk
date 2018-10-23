<?php
/**
 * Ce template appel la vue: "liste-item" pour chaque document.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.1.9
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

if ( ! empty( $documents ) ) :
	foreach ( $documents as $document ) :
		\eoxia\View_Util::exec( 'digirisk', 'duer', 'list-item', array( 'document' => $document ) );
	endforeach;
endif;
