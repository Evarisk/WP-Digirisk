<?php
/**
 * Edition d'un risque
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="risk-row edit" data-id="<?php echo esc_attr( $risk->data['id'] ); ?>">

	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="action" value="edit_risk" />
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $society_id ); ?>" />
	<input type="hidden" name="id" value="<?php echo $risk->data['preset'] ? 0 : esc_attr( $risk->data['id'] ); ?>" />
	<input type="hidden" name="from_preset" value="<?php echo $risk->data['preset'] ? 1 : 0; ?>" />
	<?php wp_nonce_field( 'edit_risk' ); ?>

	<td data-title="Ref." class="padding">
		<?php if ( $risk->data['preset'] ) : ?>
			-
		<?php
		else :
			if ( 0 !== $risk->data['id'] ) :
				?>
				<span><strong><?php echo esc_html( $risk->data['unique_identifier'] . ' - ' . $risk->data['evaluation']->data['unique_identifier'] ); ?></span></strong>
				<?php
			endif;
		endif;
		?>
	</td>
	<td data-title="Risque" data-title="Risque" class="w50">
		<?php
		if ( isset( $can_edit_risk_category ) && $can_edit_risk_category ) :
			do_shortcode( '[digi_dropdown_categories_risk id="' . $risk->data['id'] . '" type="risk" display="edit" category_risk_id="' . $risk->data['risk_category']->data['id'] . '" preset="' . ( ( $risk->data['preset'] ) ? '1' : '0' ) . '"]' );
		else :
			do_shortcode( '[digi_dropdown_categories_risk id="' . $risk->data['id'] . '" type="risk" display="' . ( ( 0 !== $risk->data['id'] && ! $risk->data['preset'] ) ? 'view' : 'edit' ) . '" category_risk_id="' . $risk->data['risk_category']->data['id'] . '" preset="' . ( ( $risk->data['preset'] ) ? '1' : '0' ) . '"]' );
		endif;
		?>
	</td>
	<td data-title="Cot." class="w50">
		<?php do_shortcode( '[digi_dropdown_evaluation_method risk_id=' . $risk->data['id'] . ']' ); ?>
	</td>
	<td data-title="Photo" class="w50">
		<?php echo do_shortcode( '[wpeo_upload id="' . ( ( $risk->data['preset'] ) ? 0 : $risk->data['id'] ) . '" model_name="' . $risk->get_class() . '" single="false" field_name="image" title="' . $risk->data['unique_identifier'] . ' - ' . $risk->data['evaluation']->data['unique_identifier'] . '" ]' ); ?>
	</td>
	<td data-title="Commentaire" class="padding">
		<?php do_shortcode( '[digi_comment id="' . $risk->data['id'] . '" namespace="digi" type="risk_evaluation_comment" display="edit" add_button="' . ( ( $risk->data['preset'] ) ? '0' : '1' ) . '"]' ); ?>
	</td>
	<td data-title="action">
		<?php if ( 0 !== $risk->data['id'] && false === $risk->data['preset'] ) : ?>
			<div class="action">
				<div data-parent="risk-row" data-loader="table" class="wpeo-button button-square-50 button-green save action-input"><i class="button-icon fas fa-save"></i></div>
			</div>
		<?php else : ?>
			<div class="action">
				<?php if ( -1 != $risk->data['risk_category']->data['id'] && -1 != $risk->data['evaluation']->data['scale'] ) : ?>
					<div data-namespace="digirisk"
						data-module="risk"
						data-before-method="beforeSaveRisk"
						data-loader="table"
						data-parent="risk-row"
						class="wpeo-button button-square-50 add action-input button-progress">
							<i class="button-icon fas fa-plus"></i></div>
				<?php else : ?>
					<div data-namespace="digirisk"
						data-module="risk"
						data-before-method="beforeSaveRisk"
						data-loader="table"
						data-parent="risk-row"
						class="wpeo-button button-square-50 button-disable button-event add action-input button-progress">
							<i class="button-icon fas fa-plus"></i></div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</td>
</tr>
