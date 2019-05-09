<?php
/**
 * Le template pour afficher une ligne de signalisation dans le tableau d'édition des signalisations.
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

<tr class="recommendation-row" data-id="<?php echo esc_attr( $recommendation->data['id'] ); ?>">
	<td class="padding">
		<span><strong><?php echo esc_html( $recommendation->data['unique_identifier'] ); ?></span></strong>
	</td>
	<td>
		<?php do_shortcode( '[dropdown_recommendation id="' . $recommendation->data['id'] . '" type="recommendation" display="view"]' ); ?>
	</td>
	<td class="w50">
		<?php echo do_shortcode( '[wpeo_upload id="' . $recommendation->data['id'] . '" model_name="/digi/Recommendation" field_name="image" title="' . $recommendation->data['unique_identifier'] . '" ]' ); ?>
	</td>
	<td class="padding">
		<?php do_shortcode( '[digi_comment id="' . $recommendation->data['id'] . '" namespace="digi" type="recommendation_comment" display="view"]' ); ?>
	</td>
	<td>
		<div class="action wpeo-gridlayout grid-2">
			<!-- Editer une recommendation -->
			<div 	class="wpeo-button button-square-50 button-transparent edit action-attribute"
						data-id="<?php echo esc_attr( $recommendation->data['id'] ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_recommendation' ) ); ?>"
						data-loader="table"
						data-action="load_recommendation"><i class="button-icon fas fa-pencil-alt"></i></div>

			<div 	class="wpeo-button button-square-50 button-transparent delete action-delete"
						data-id="<?php echo esc_attr( $recommendation->data['id'] ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_recommendation' ) ); ?>"
						data-action="delete_recommendation"
						data-message-delete="<?php esc_attr_e( 'Êtes-vous sûr(e) de vouloir supprimer cette signalisation ?', 'digirisk' ); ?>"><i class="button-icon fas fa-times"></i></div>
		</div>
	</td>
</tr>
