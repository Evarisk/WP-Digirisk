<?php
/**
 * Template pour les informations de la société.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     7.2.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<h3><?php esc_html_e( 'Document unique', 'digirisk' ); ?></h3>

<div class="wpeo-gridlayout grid-3">
	<p>
		<span><?php esc_html_e( 'Date dernière impression:', 'digirisk' ); ?></span>
		<span><strong><?php echo ( ! empty( $current_duer ) ) ? $current_duer->data['date']['rendered']['date'] : __( 'N/A', 'digirisk' ); ?></strong></span>
	</p>
	<p><?php printf( __( 'Mise à jour obligatoire tous les <strong>%d</strong> jours', 'digirisk' ), $general_options['required_duer_day'] ); ?></p>
	<p><?php printf( __( 'Nombre de jours restant avant la prochaine mise à jour obligatoire: <strong>%s</strong> jours', 'digirisk' ), ! empty( $date_before_next_duer ) ? $date_before_next_duer : 'N/A' ); ?></p>
</div>

<h3><?php esc_html_e( 'Accident', 'digirisk' ); ?></h3>

<div class="wpeo-gridlayout grid-3">
	<p>
		<span><?php esc_html_e( 'Date du dernier accident:', 'digirisk' ); ?></span>
		<span><strong><?php echo ( ! empty( $accident ) ) ? $accident->data['date']['rendered']['date'] : __( 'N/A', 'digirisk' ); ?></strong></span>
	</p>
	<p><?php _e( 'Nombre de jour sans Accident: <strong>N/A</strong> jours', 'digirisk' ); ?></p>
	<p><?php printf( __( 'Unité de Travail concernée: <strong>%s</strong>', 'digirisk' ), ! empty( $accident ) ? $accident->data['place']->data['unique_identifier'] . ' - ' . $accident->data['place']->data['title'] : 'N/A' ); ?></p>
</div>

<h3><?php esc_html_e( 'Analyse par unité de travail ou GP', 'digirisk' ); ?></h3>

<div class="wpeo-gridlayout grid-3">
	<p>
		<span><?php esc_html_e( 'Date de l\'action:', 'digirisk' ); ?></span>
		<span><strong><?php echo ( ! empty( $historic_update ) && isset( $historic_update['date']['date'] ) ) ? $historic_update['date']['date'] : 'N/A'; ?></strong></span>
	</p>
	<p><?php printf( __( 'UT ou GP: <strong>%s</strong>', 'digirisk' ), ( ! empty( $historic_update['parent_id'] ) ) ? $historic_update['parent']->data['unique_identifier'] . ' - ' . $historic_update['parent']->data['title'] : 'N/A' ); ?></p>
	<p><?php printf( __( 'Description de l\'action: <strong>%s</strong>', 'digirisk' ), ! empty( $historic_update ) ? $historic_update['content'] : 'N/A' ); ?></p>
</div>

<h3><?php _e( 'Analyse par personne', 'digirisk' ); ?></h3>

<div class="wpeo-gridlayout grid-3">
	<p>
		<span><?php _e( 'Nombre de personnes sur l\'établissement:', 'digirisk' ); ?></span>
		<span><strong><?php echo esc_html( $total_users ); ?></strong></span>
	</p>
	<p><?php printf( __( 'Nombre de personnes impliqués: <strong>%s évaluateur(s)</strong>', 'digirisk' ), $number_evaluator ); ?></p>
	<p><?php printf( __( 'Pourcentage: <strong>%s</strong>', 'digirisk' ), $average ); ?></p>
</div>

<div class="section-risk"></div>
