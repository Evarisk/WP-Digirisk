<?php
/**
 * Affichage d'un accident
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<tr class="accident-row">
	<td data-title="Ref." class="padding">
		<span><strong><?php echo esc_html( $accident->modified_unique_identifier ); ?></span></strong>
	</td>
	<td data-title="Risque associé" class="padding">
		Risque
	</td>
	<td data-title="Date et heure" class="padding">
		Date et heure
	</td>
	<td data-title="Identité victime" class="padding">
		Identité victime
	</td>
	<td data-title="Circonstances détaillées" class="padding">
		Circonstances détaillés
	</td>
	<td data-title="Opt. avancées">
		icone
	</td>
	<td data-title="Action">
		<div class="action grid-layout w3">
			<div 	class="open-popup-ajax button light w50 task"
						data-parent="risk-row"
						data-target="corrective-task"
						data-action="open_task"
						data-id="<?php echo esc_attr( $accident->id ); ?>"><i class="icon dashicons dashicons-schedule"></i></div>

			<!-- Editer un risque -->
			<div 	class="button light w50 edit action-attribute"
						data-id="<?php echo esc_attr( $accident->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_risk' ) ); ?>"
						data-loader="risk"
						data-action="load_risk"><i class="icon fa fa-pencil"></i></div>

			<div 	class="button light w50 delete action-delete"
						data-id="<?php echo esc_attr( $accident->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_risk' ) ); ?>"
						data-action="delete_risk"><i class="icon fa fa-times"></i></div>
		</div>
	</td>
</tr>
