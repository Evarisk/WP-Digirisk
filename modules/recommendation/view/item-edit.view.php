<?php
/**
 * Edition d'une recommendation
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

<tr class="recommendation-row edit">

	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="action" value="save_recommendation" />
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $society_id ); ?>" />
	<input type="hidden" name="id" value="<?php echo esc_attr( $recommendation->data['id'] ); ?>" />
	<?php wp_nonce_field( 'save_recommendation' ); ?>

	<td class="padding w50">
		<span><strong><?php echo esc_html( $recommendation->data['unique_identifier'] ); ?></span></strong>
	</td>
	<td class="wm130 w150">
		<?php do_shortcode( '[dropdown_recommendation id="' . $recommendation->data['id'] . '" type="recommendation"]' ); ?>
	</td>
	<td class="w50">
		<?php do_shortcode( '[wpeo_upload id="' . $recommendation->data['id'] . '" model_name="/digi/Recommendation_Class" field_name="image"  title="' . $recommendation->data['unique_identifier'] . '"]' ); ?>
	</td>
	<td class="padding">
		<?php do_shortcode( '[digi_comment id="' . $recommendation->data['id'] . '" namespace="digi" type="recommendation_comment" display="edit"]' ); ?>
	</td>
	<td>
		<?php if ( 0 !== $recommendation->data['id'] ) : ?>
			<div class="action grid-layout w2">
				<div data-parent="recommendation-row" data-loader="table" class="button w50 green save action-input"><i class="icon fas fa-save"></i></div>
			</div>
		<?php else : ?>
			<div class="action grid-layout w2">
				<div	data-namespace="digirisk"
							data-module="recommendation"
							data-before-method="beforeSaveRecommendation"
							data-parent="recommendation-row"
							data-loader="table"
							class="button w50 disable add action-input"><i class="icon far fa-plus"></i></div>
			</div>
		<?php endif; ?>
	</td>
</tr>
