<?php
/**
 * Mise à jour des données pour la 6.6.3
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.6.3
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

$datas = array(
	array(
		'action'         => 'digirisk_merge_data',
		'title'          => __( 'Remise en place des données des sociétés', 'digirisk' ),
		'description'    => __( '', 'digirisk' ),
		'since'          => '6.6.3',
		'update_index'   => '663a',
		'count_callback' => '',
	),
);
