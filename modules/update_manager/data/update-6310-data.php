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
		'action'         => 'digirisk_update_risk_equivalence',
		'title'          => __( 'Mise à jour des cotations des risques', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '6310a',
		'count_callback' => '',
	),
);
