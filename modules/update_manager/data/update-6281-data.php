<?php
/**
 * Mise à jour des données pour la 6.2.8
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.8
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

$datas = array(
	array(
		'action'         => 'digirisk_update_roles',
		'title'          => __( 'Mise à jour des rôles des utilisateurs', 'digirisk' ),
		'description'    => __( 'Mise à jour des rôles', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '628a',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_danger_category_picto',
		'title'          => __( 'Mise à jour des pictogrammes des catégories de risques', 'digirisk' ),
		'description'    => __( 'Mise à jour des pictogrammes.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '628b',
		'count_callback' => '',
	),
);
