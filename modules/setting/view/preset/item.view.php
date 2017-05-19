<?php
/**
 * Affichage d'un risque à preset.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.9.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<tr class="risk-row edit">

	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="action" value="edit_risk" />
	<input type="hidden" name="parent_id" value="0" />
	<input type="hidden" name="page" value="setting_risk" />
	<input type="hidden" name="risk[id]" value="<?php echo esc_attr( $danger->id ); ?>" />

	<td class="wm130 w150">
		<?php do_shortcode( '[digi_evaluation_method_evarisk risk_id=' . $danger->id . ' type="risk"]' ); ?>
		<?php do_shortcode( '[dropdown_danger id="' . $danger->id . '" danger_id="' . $danger->id . '" preset="1" type="risk" display="' . ( ( $danger->id !== 0 ) ? "view" : "edit" ) . '"]' ); ?>
	</td>
	<td class="w50">
		<?php do_shortcode( '[digi_evaluation_method risk_id=' . $danger->id . ']' ); ?>
	</td>
	<td class="padding">
		<?php do_shortcode( '[digi_comment id="' . $danger->id . '" namespace="digi" type="risk_evaluation_comment" display="edit"]' ); ?>
	</td>
	<td>
		<div class="action grid-layout w3">
			<div data-namespace="digirisk" data-module="risk" data-before-method="beforeSaveRisk" data-parent="risk-row" data-loader="table" class="button w50 green save action-input"><i class="icon fa fa-floppy-o"></i></div>
		</div>
	</td>
</tr>
