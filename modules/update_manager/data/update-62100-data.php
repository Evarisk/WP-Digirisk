<?php
/**
 * Mise à jour des données pour la 6.2.10
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.10
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

$datas = array(
	array(
		'action'         => 'digirisk_update_risk_cotation',
		'title'          => __( 'Mise à jour des cotations', 'digirisk' ),
		'description'    => __( 'Mise à jour des cotations.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '6210a',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_doc',
		'title'          => __( 'Mise à jour des documents', 'digirisk' ),
		'description'    => __( 'Mise à jour des documents.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '6210b',
		'count_callback' => '',
	),
);
