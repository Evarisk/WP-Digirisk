<?php
/**
 * Edition d'un accident
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<tr class="accident-row edit">

	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="action" value="edit_accident" />
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $society_id ); ?>" />
	<input type="hidden" name="risk[id]" value="<?php echo esc_attr( $accident->id ); ?>" />

	<td data-title="Ref." class="padding">
		ref
	</td>
	<td data-title="Risque" data-title="Risque" class="padding">
		<?php do_shortcode( '[digi_dropdown_risk society_id=' . $society_id . ' element_id=' . $accident->id . ' risk_id=' . $accident->risk_id . ']' ); ?>
	</td>
	<td data-title="Date et heure" class="padding">
		<input type="text" name="" class=".date-time" placeholder="04/01/2017" value="<?php echo esc_html( $accident->date ); ?>" />
	</td>
	<td data-title="Identité victime" class="padding">
		<input type="text" />
	</td>
	<td data-title="Circonstances détaillées" class="padding">
		<input type="text" />
	</td>
	<td data-title="Opt. Avancées">
		opt avancées
	</td>
	<td data-title="action">
		<?php if ( 0 !== $accident->id ) : ?>
			<div class="action grid-layout w3">
				<div data-parent="risk-row" data-loader="table" class="button w50 green save action-input"><i class="icon fa fa-floppy-o"></i></div>
			</div>
		<?php else : ?>
			<div class="action grid-layout w3">
				<div data-namespace="digirisk" data-module="risk" data-before-method="beforeSaveRisk" data-loader="table" data-parent="risk-row" class="button w50 blue add action-input progress"><i class="icon fa fa-plus"></i></div>
			</div>
		<?php endif; ?>
	</td>
</tr>
