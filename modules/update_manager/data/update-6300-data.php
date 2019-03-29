<?php
/**
 * Mise à jour des données pour la 6.3.0
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.3.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

$datas = array(
	array(
		'action'         => 'digirisk_update_create_society',
		'title'          => __( 'Mise à jour des sociétés', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '630a',
		'count_callback' => '',
	),
);
