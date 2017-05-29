<?php
/**
 * Edition d'une recommendation
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package recommendation
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<tr class="recommendation-row edit">

	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="action" value="save_recommendation" />
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $society_id ); ?>" />
	<input type="hidden" name="id" value="<?php echo esc_attr( $recommendation->id ); ?>" />
	<?php wp_nonce_field( 'save_recommendation' ); ?>

	<td class="padding w50">
		<span><strong><?php echo esc_html( $recommendation->unique_identifier ); ?></span></strong>
	</td>
	<td class="wm130 w150">
		<?php do_shortcode( '[dropdown_recommendation id="' . $recommendation->id . '" type="recommendation"]' ); ?>
	</td>
	<td class="w50">
		<?php do_shortcode( '[eo_upload_button id="' . $recommendation->id . '" type="recommendation"]' ); ?>
	</td>
	<td class="padding">
		<?php do_shortcode( '[digi_comment id="' . $recommendation->id . '" namespace="digi" type="recommendation_comment" display="edit"]' ); ?>
	</td>
	<td>
		<?php if ( 0 !== $recommendation->id ) : ?>
			<div class="action grid-layout w2">
				<div data-parent="recommendation-row" data-loader="table" class="button w50 green save action-input"><i class="icon fa fa-floppy-o"></i></div>
			</div>
		<?php else : ?>
			<div class="action grid-layout w2">
				<div	data-namespace="digirisk"
							data-module="recommendation"
							data-before-method="beforeSaveRecommendation"
							data-parent="recommendation-row"
							data-loader="table"
							class="button w50 disable add action-input"><i class="icon fa fa-plus"></i></div>
			</div>
		<?php endif; ?>
	</td>
</tr>
