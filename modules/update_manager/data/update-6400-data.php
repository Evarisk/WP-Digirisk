<?php
/**
 * Mise à jour des données pour la 6.4.0
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.4.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

$datas = array(
	array(
		'action'         => 'digirisk_update_to_ed840_danger',
		'title'          => __( 'Mise à jour des catégories de risques', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '640a',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_to_ed840_to_risk',
		'title'          => __( 'Mise à jour des catégories de risques sur les risques', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '640b',
		'count_callback' => '',
	),
);
