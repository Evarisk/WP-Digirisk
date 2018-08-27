<?php
/**
 * Mise à jour des données pour la 7.0.0
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

$datas = array(
	array(
		'action'         => 'digirisk_update_700_update_society',
		'title'          => __( 'Update society', 'digirisk' ),
		'description'    => __( 'Society', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700a',
		'count_callback' => '',
	),
);
