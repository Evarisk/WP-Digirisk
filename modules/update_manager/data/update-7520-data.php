<?php
/**
 * Mise à jour des données pour la 7.5.2
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     7.5.2
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

$datas = array(
	array(
		'action'         => 'digirisk_update_752_update_signature_accident',
		'title'          => __( 'Mise à jour des medias des accidents', 'digirisk' ),
		'description'    => __( '.', 'digirisk' ),
		'since'          => '7.5.2',
		'update_index'   => '752a',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_752_update_signature_causerie',
		'title'          => __( 'Mise à jour des medias des causeries', 'digirisk' ),
		'description'    => __( '.', 'digirisk' ),
		'since'          => '7.5.2',
		'update_index'   => '752b',
		'count_callback' => '',
	),
);
