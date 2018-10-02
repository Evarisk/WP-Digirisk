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
		'title'          => __( 'Mise à jour des sociétés', 'digirisk' ),
		'description'    => __( 'Mise à jour des status.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700a',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_update_risk',
		'title'          => __( 'Mise à jour des risques', 'digirisk' ),
		'description'    => __( 'Mise à jour des quotations.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700b',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_update_risk_comments',
		'title'          => __( 'Mise à jour des commentaires des risques', 'digirisk' ),
		'description'    => __( 'Mise à jour des commentaires.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700c',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_update_legal_display',
		'title'          => __( 'Mise à jour de l\'affichage légal', 'digirisk' ),
		'description'    => __( 'Mise à jour des données.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700d',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_update_legal_display_doc',
		'title'          => __( 'Mise à jour des documents des affichages légaux', 'digirisk' ),
		'description'    => __( 'Mise à jour des documents.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700e',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_update_diffusion_information',
		'title'          => __( 'Mise à jour des documents des diffusions d\'informations', 'digirisk' ),
		'description'    => __( 'Mise à jour des documents.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700f',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_update_sheet_groupment',
		'title'          => __( 'Mise à jour des documents des fiches de groupement', 'digirisk' ),
		'description'    => __( 'Mise à jour des documents.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700g',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_update_sheet_workunit',
		'title'          => __( 'Mise à jour des documents des fiches de poste', 'digirisk' ),
		'description'    => __( 'Mise à jour des documents.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700h',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_update_recommendation_category',
		'title'          => __( 'Mise à jour des catégories de signalisation', 'digirisk' ),
		'description'    => __( 'Mise à jour des données.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700i',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_update_duer',
		'title'          => __( 'Mise à jour des DUER', 'digirisk' ),
		'description'    => __( 'Mise à jour du document et des données.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700j',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_update_evaluation_method',
		'title'          => __( 'Mise à jour des méthodes d\'évaluation', 'digirisk' ),
		'description'    => __( 'Mise à jour des données.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700k',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_update_accident',
		'title'          => __( 'Mise à jour des accidents', 'digirisk' ),
		'description'    => __( 'Mise à jour des données des accidents.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700l',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_registre_at_benin',
		'title'          => __( 'Mise à jour des registres des AT Bénins', 'digirisk' ),
		'description'    => __( 'Mise à jour des données.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700m',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_recommendation_comments',
		'title'          => __( 'Mise à jour des commentaires des signalisations', 'digirisk' ),
		'description'    => __( 'Mise à jour des données.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700n',
		'count_callback' => '',
	),
	array(
		'action'         => 'digirisk_update_700_listing_risk',
		'title'          => __( 'Mise à jour des listes de risque', 'digirisk' ),
		'description'    => __( 'Mise à jour des données.', 'digirisk' ),
		'since'          => '7.0.0',
		'update_index'   => '700o',
		'count_callback' => '',
	),
);
