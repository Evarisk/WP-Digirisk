<?php
/**
 * La vue principale des signalisations.
 *
 * Appel la méthode "display" de Recommendation_Class.
 * Appel la vue "item-edit".
 *
 * @author Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license AGPLv3 <https://spdx.org/licenses/AGPL-3.0-only.html>
 *
 * @package DigiRisk
 *
 * @since 6.2.1
 * @version 7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

Recommendation_Class::g()->display( $society_id );

\eoxia\View_Util::exec( 'digirisk', 'recommendation', 'item-edit', array(
	'society_id'     => $society_id,
	'recommendation' => $recommendation,
	'index'          => $index,
) );
