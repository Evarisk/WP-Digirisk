<?php
/**
 * Le template pour afficher le formulaire d'édition d'une signlisation.
 *
 * Ce template utilise 3 shortcodes: dropdown_recommendation permet d'afficher
 * la liste déroulante contenant les catégories de recommendation. Le shortcode
 * wpeo_upload permettant de gérer la gestion des images sur un post de
 * WordPress. Le shortcode digi_comment qui permet de gérer les commentaires
 * en mode formulaire avec DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-only.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.2.1
 * @version   7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

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
		<?php echo do_shortcode( '[wpeo_upload id="' . $recommendation->data['id'] . '" model_name="/digi/Recommendation" field_name="image"  title="' . $recommendation->data['unique_identifier'] . '"]' ); ?>
	</td>
	<td class="padding">
		<?php do_shortcode( '[digi_comment id="' . $recommendation->data['id'] . '" namespace="digi" type="recommendation_comment" display="edit"]' ); ?>
	</td>
	<td>
		<?php if ( 0 !== $recommendation->data['id'] ) : ?>
			<div class="action">
				<div data-parent="recommendation-row" data-loader="table" class="wpeo-button button_square-50 button-green save action-input"><i class="button-icon fas fa-save"></i></div>
			</div>
		<?php else : ?>
			<div class="action">
				<div	data-namespace="digirisk"
							data-module="recommendation"
							data-before-method="beforeSaveRecommendation"
							data-parent="recommendation-row"
							data-loader="table"
							class="wpeo-button button-square-50 button-disable button-event add action-input"><i class="button-icon fas fa-plus"></i></div>
			</div>
		<?php endif; ?>
	</td>
</tr>
