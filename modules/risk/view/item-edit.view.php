<?php
/**
 * Edition d'un risque
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="risk-row edit">

	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="action" value="edit_risk" />
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $society_id ); ?>" />
	<input type="hidden" name="risk[id]" value="<?php echo $risk->preset ? 0 : esc_attr( $risk->id ); ?>" />
	<input type="hidden" name="risk[preset]" value="0" />

	<td data-title="Ref." class="padding">
		<?php do_shortcode( '[digi_evaluation_method_evarisk risk_id=' . $risk->id . ' type="risk"]' ); ?>

		<?php if ( $risk->preset ) : ?>
			-
		<?php else : ?>
			<span><strong><?php echo esc_html( $risk->modified_unique_identifier . ' - ' . $risk->evaluation->unique_identifier ); ?></span></strong>
		<?php endif; ?>
	</td>
	<td data-title="Risque" data-title="Risque" class="wmax70">
		<?php do_shortcode( '[digi-dropdown-categories-risk id="' . $risk->id . '" type="risk" display="' . ( ( 0 !== $risk->id && ! $risk->preset ) ? 'view' : 'edit' ) . '" category_risk_id="' . $risk->risk_category->id . '" preset="' . ( ( $risk->preset ) ? '1' : '0' ) . '"]' ); ?>
	</td>
	<td data-title="Cot." class="w50">
		<?php do_shortcode( '[digi_evaluation_method risk_id=' . $risk->id . ']' ); ?>
	</td>
	<td data-title="Photo" class="w50">
		<?php do_shortcode( '[wpeo_upload id="' . $risk->id . '" model_name="/digi/' . $risk->get_class() . '" field_name="image" ]' ); ?>
	</td>
	<td data-title="Commentaire" class="padding">
		<?php do_shortcode( '[digi_comment id="' . $risk->id . '" namespace="digi" type="risk_evaluation_comment" display="edit" add_button="' . ( ( $risk->preset ) ? '0' : '1' ) . '"]' ); ?>
	</td>
	<td data-title="action">
		<?php if ( 0 !== $risk->id && false === $risk->preset ) : ?>
			<div class="action grid-layout w3">
				<div data-parent="risk-row" data-loader="table" class="button w50 green save action-input"><i class="icon fa fa-floppy-o"></i></div>
			</div>
		<?php else : ?>
			<div class="action grid-layout w3">
				<?php if ( -1 != $risk->risk_category->id && -1 != $risk->evaluation->scale ) : ?>
					<div data-namespace="digirisk" data-module="risk" data-before-method="beforeSaveRisk" data-loader="table" data-parent="risk-row" class="button w50 blue add action-input progress"><i class="icon fa fa-plus"></i></div>
				<?php else : ?>
					<div data-namespace="digirisk" data-module="risk" data-before-method="beforeSaveRisk" data-loader="table" data-parent="risk-row" class="button w50 disable add action-input progress"><i class="icon fa fa-plus"></i></div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</td>
</tr>
