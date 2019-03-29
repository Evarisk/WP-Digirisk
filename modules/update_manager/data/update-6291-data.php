<?php
/**
 * Mise à jour des données pour la 6.2.9
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.9
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

$datas = array(
	array(
		'action'         => 'digirisk_update_recreate_category_danger',
		'title'          => __( 'Mise à jour des catégories de risque', 'digirisk' ),
		'description'    => __( 'Mise à jour des catégories de risque', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '629a',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_associate_danger_to_risk',
		'title'          => __( 'Mise à jour des catégories de risque sur les risques', 'digirisk' ),
		'description'    => __( 'Mise à jour des catégories de risque sur les risques', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '629b',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_roles_2',
		'title'          => __( 'Mise à jour des rôles', 'digirisk' ),
		'description'    => __( 'Mise à jour des rôles.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '629c',
		'count_callback' => '',
	),
);
