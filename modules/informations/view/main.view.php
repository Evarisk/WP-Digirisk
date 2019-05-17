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

<h3>Document unique</h3>

<div class="wpeo-gridlayout grid-3">
	<p>
		<span>Date dernière impression:</span>
		<span><strong><?php echo ( ! empty( $current_duer ) ) ? $current_duer->data['date']['rendered']['date'] : 'N/A'; ?></strong></span>
	</p>
	<p>Mise à jour obligatoire tous les <strong>N/A</strong> jours</p>
	<p>Nombre de jours restant avant la prochaine mise à jour obligatoire: <strong>N/A</strong></p>
</div>

<h3>Accident</h3>

<div class="wpeo-gridlayout grid-3">
	<p>
		<span>Date du dernier accident:</span>
		<span><strong><?php echo ( ! empty( $accident ) ) ? $accident->data['date']['rendered']['date'] : 'N/A'; ?></strong></span>
	</p>
	<p>Nombre de jour sans Accident: <strong>N/A</strong> jours</p>
	<p>Unité de Travail concernée: <strong><?php echo ( ! empty( $accident ) ) ? $accident->data['place']->data['unique_identifier'] . ' - ' . $accident->data['place']->data['title'] : 'N/A'; ?></strong></p>
</div>

<h3>Analyse par unité de travail ou GP</h3>

<div class="wpeo-gridlayout grid-3">
	<p>
		<span>Date de l'action:</span>
		<span><strong><?php echo ( ! empty( $historic_update ) ) ? $historic_update['date']['date'] : 'N/A'; ?></strong></span>
	</p>
	<p>UT ou GP: <strong><?php echo ( ! empty( $historic_update['parent_id'] ) ) ? $historic_update['parent']->data['unique_identifier'] . ' - ' . $historic_update['parent']->data['title'] : 'N/A'; ?></strong></p>
	<p>Description de l'action: <strong><?php echo ! empty( $historic_update ) ? $historic_update['content'] : 'N/A'; ?></strong></p>
</div>

<h3>Analyse par personne</h3>

<div class="wpeo-gridlayout grid-3">
	<p>
		<span>Nombre de personnes sur l'établissement:</span>
		<span><strong><?php echo esc_html( $total_users ); ?></strong></span>
	</p>
	<p>Nombre de personnes impliqués: <strong><?php echo $number_evaluator; ?> évaluateur(s)</strong></p>
	<p>Pourcentage: <strong><?php echo $average; ?></strong></p>
</div>

<h3>Analyse des risques</h3>

<h4>Analyse par nombre de risques et cotations</h4>

<div class="wpeo-table table-flex table-4">
	<div class="table-row table-header">
		<div class="table-cell"></div>
		<div class="table-cell" data-title="Nombre de risques">Nombre de risques</div>
		<div class="table-cell" data-title="Somme des cotations">Sommes des cotations</div>
		<div class="table-cell" data-title="Somme des cotations">Moyenne des cotations</div>
	</div>

	<div class="table-row">
		<div class="table-cell" data-title="Nombre de risques sur le DU précédent">Nombre de risque sur le DU précédent</div>
		<div class="table-cell"><?php echo $old_duer_info['total_risk']; ?></div>
		<div class="table-cell"><?php echo $old_duer_info['quotation_total']; ?></div>
		<div class="table-cell"><?php echo round( $old_duer_info['average'] ); ?></div>
	</div>

	<div class="table-row">
		<div class="table-cell" data-title="Nombre de risque sur le DU actuel">Nombre de risque sur le DU actuel</div>
		<div class="table-cell"><?php echo $current_duer_info['total_risk']; ?></div>
		<div class="table-cell"><?php echo $current_duer_info['quotation_total']; ?></div>
		<div class="table-cell"><?php echo round( $current_duer_info['average'] ); ?></div>
	</div>

	<div class="table-row">
		<div class="table-cell" data-title="Progression">Progression</div>
		<div class="table-cell"><?php echo $diff_info['total_risk']; ?></div>
		<div class="table-cell"><?php echo $diff_info['quotation_total']; ?></div>
		<div class="table-cell"><?php echo round( $diff_info['average'] ); ?></div>
	</div>
</div>

<h4>Analyse des risques par cotation</h4>

<div class="wpeo-table table-flex table-5">
	<div class="table-row table-header">
		<div class="table-cell">Cotation</div>
		<div class="table-cell" data-title="Gris">Gris</div>
		<div class="table-cell" data-title="Orange">Orange</div>
		<div class="table-cell" data-title="Rouge">Rouge</div>
		<div class="table-cell" data-title="Noir">Noir</div>
	</div>

	<div class="table-row">
		<div class="table-cell" data-title="Nombre de risques sur le DU précédent">Nombre DU précédent</div>
		<div class="table-cell"><?php echo $old_duer_info['number_risk'][1]; ?></div>
		<div class="table-cell"><?php echo $old_duer_info['number_risk'][2]; ?></div>
		<div class="table-cell"><?php echo $old_duer_info['number_risk'][3]; ?></div>
		<div class="table-cell"><?php echo $old_duer_info['number_risk'][4]; ?></div>
	</div>

	<div class="table-row">
		<div class="table-cell" data-title="Nombre de risques sur le DU précédent">Nombre DU actuel</div>
		<div class="table-cell"><?php echo $current_duer_info['number_risk'][1]; ?></div>
		<div class="table-cell"><?php echo $current_duer_info['number_risk'][2]; ?></div>
		<div class="table-cell"><?php echo $current_duer_info['number_risk'][3]; ?></div>
		<div class="table-cell"><?php echo $current_duer_info['number_risk'][4]; ?></div>
	</div>

	<div class="table-row">
		<div class="table-cell" data-title="Nombre de risques sur le DU précédent">Progression</div>
		<div class="table-cell"><?php echo $diff_info['number_risk'][1]; ?></div>
		<div class="table-cell"><?php echo $diff_info['number_risk'][2]; ?></div>
		<div class="table-cell"><?php echo $diff_info['number_risk'][3]; ?></div>
		<div class="table-cell"><?php echo $diff_info['number_risk'][4]; ?></div>
	</div>
</div>

<h4>Analyse des risques par famille de risque</h4>


<div class="wpeo-table table-flex table-5">
	<div class="table-row table-header">
		<div class="table-cell table-75">Famille</div>
		<div class="table-cell" data-title="Gris">Gris</div>
		<div class="table-cell" data-title="Orange">Orange</div>
		<div class="table-cell" data-title="Rouge">Rouge</div>
		<div class="table-cell" data-title="Noir">Noir</div>
	</div>

	<?php
	if ( ! empty( $risks_categories ) ) :
		foreach ( $risks_categories as $risk_category ) :
			?>
			<div class="table-row">
				<div class="table-cell table-75">
					<div class="wpeo-tooltip-event hover" aria-label="<?php echo esc_attr( $risk_category->data['name'] ); ?>">
						<?php echo wp_get_attachment_image( $risk_category->data['thumbnail_id'], 'thumbnail', false ); ?>
					</div>
				</div>

				<div class="table-cell"><?php echo esc_html( $risk_category->data['level1'] ); ?></div>
				<div class="table-cell"><?php echo esc_html( $risk_category->data['level2'] ); ?></div>
				<div class="table-cell"><?php echo esc_html( $risk_category->data['level3'] ); ?></div>
				<div class="table-cell"><?php echo esc_html( $risk_category->data['level4'] ); ?></div>
			</div>
			<?php
		endforeach;
	endif;
	?>
</div>
