<?php
/**
 * Affiches la liste des causeries
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap digirisk-wrap">
	<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie' ) ); ?>"><?php esc_html_e( 'Retour', 'digirisk' ); ?></a>

	<h2><?php esc_html_e( 'Causerie en cours', 'digirisk' ); ?></h2>

	<div class="step install">
		<ul class="step-list">
			<li class="step"><span class="title"><?php esc_html_e( 'Signature du formateur', 'digirisk' ); ?></span></li>
			<li class="step " data-width="50"><span class="title"><?php esc_html_e( 'Lecture de la causerie', 'digirisk' ); ?></span></li>
			<li class="step active" data-width="100"><span class="title"><?php esc_html_e( 'Enregistrement des participants', 'digirisk' ); ?></span></li>
		</ul>
		<div class="bar">
			<div class="background"></div>
			<div class="loader" data-width="0"></div>
		</div>
	</div>

	<div class="main-content">
		<p>Causerie XXX - Risque associé</p>
		<p>Description de ouf</p>

		<p>Participants</p>

		<table class="table causerie">
			<thead>
				<tr>
					<th class="w50 padding"><?php esc_html_e( 'Participant', 'digirisk' ); ?>.</th>
					<th class="w50 padding"><?php esc_html_e( 'Signature', 'digirisk' ); ?>.</th>
					<th class="w50 padding"><?php esc_html_e( 'Actions', 'digirisk' ); ?>.</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td class="w50 padding">Liste déroulante</td>
					<td class="w50 padding">
						<div class="wpeo-button button-blue">
							<span><?php esc_html_e( 'Signé', 'digirisk' ); ?></span>
						</div>
					</td>
					<td>
						+
					</td>
				</tr>
			</tbody>
		</table>

		<div class="wpeo-button button-main">
			<span><?php esc_html_e( 'Cloturer la causerie', 'digirisk' ); ?></span>
		</div>
	</div>
</div>
