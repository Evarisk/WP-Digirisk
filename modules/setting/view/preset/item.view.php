<?php
/**
 * Affichage d'un risque à preset.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.9
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="risk-row edit" data-id="<?php echo esc_attr( $risk->data['id'] ); ?>">

	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="action" value="edit_risk" />
	<input type="hidden" name="parent_id" value="0" />
	<input type="hidden" name="page" value="setting_risk" />
	<input type="hidden" name="id" value="<?php echo esc_attr( $risk->data['id'] ); ?>" />
	<input type="hidden" name="can_update" value="true" />
	<?php wp_nonce_field( 'edit_risk' ); ?>

	<td class="w50">
		<?php do_shortcode( '[digi_evaluation_method_evarisk risk_id=' . $risk->data['id'] . ' type="risk"]' ); ?>
		<?php do_shortcode( '[digi_dropdown_categories_risk id=' . $risk->data['id'] . ' category_risk_id=' . end( $risk->data['taxonomy'][ Risk_Category_Class::g()->get_type() ] ) . ' danger_id=' . $risk->data['id'] . ' preset=1 type=risk display=' . ( ( 0 !== $risk->data['id'] ) ? 'view' : 'edit' ) . ']' ); ?>
	</td>
	<td class="w50">
		<?php do_shortcode( '[digi_dropdown_evaluation_method preset=1 risk_id=' . $risk->data['id'] . ']' ); ?>
	</td>
	<td class="padding">
		<?php do_shortcode( '[digi_comment id="' . $risk->data['id'] . '" namespace="digi" type="risk_evaluation_comment" display="edit"]' ); ?>
	</td>
	<td>
		<div class="hidden">
			<div data-namespace="digirisk"
				data-module="risk"
				data-before-method="beforeSaveRisk"
				data-parent="risk-row"
				data-loader="table"
				class="button w50 green save action-input"><i class="icon fas fa-save"></i></div>
		</div>
	</td>
</tr>
