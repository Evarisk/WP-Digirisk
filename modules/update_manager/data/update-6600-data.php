<?php
/**
 * Mise à jour des données pour la 6.6.0
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.6.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

$datas = array(
	array(
		'action'         => 'digirisk_get_societies_status',
		'title'          => __( 'Récupères les status des sociétés', 'digirisk' ),
		'description'    => __( 'Récupères les status.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '660a',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_societies_status',
		'title'          => __( 'Mise à jour des status des sociétés', 'digirisk' ),
		'description'    => __( 'Mise à jour des status.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '660b',
		'count_callback' => '',
	),
);
