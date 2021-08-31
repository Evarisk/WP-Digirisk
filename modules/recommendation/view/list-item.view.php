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

<div class="table-row recommendation-row">
	<div class="table-cell table-75">
		<strong><?php echo esc_html( $recommendation->data['unique_identifier'] ); ?></strong>
	</div>
	<div class="table-cell table-100">
		<?php do_shortcode( '[dropdown_recommendation id="' . $recommendation->data['id'] . '" type="recommendation" display="item-dropdown"]' ); ?>
	</div>
	<div class="table-cell table-50">
		<?php echo do_shortcode( '[wpeo_upload id="' . $recommendation->data['id'] . '" model_name="/digi/Recommendation" field_name="image" title="' . $recommendation->data['unique_identifier'] . '" ]' ); ?>
	</div>
	<div class="table-cell">
		<?php do_shortcode( '[digi_comment id="' . $recommendation->data['id'] . '" namespace="digi" type="recommendation_comment" display="view"]' ); ?>
	</div>
	<div class="table-cell table-100 table-end">
		<div class="action wpeo-gridlayout grid-2 grid-gap-0">
			<!-- Editer une recommendation -->
			<div 	class="wpeo-button button-square-50 button-transparent edit action-attribute"
			        data-id="<?php echo esc_attr( $recommendation->data['id'] ); ?>"
			        data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_recommendation' ) ); ?>"
			        data-loader="table-recommendation"
			        data-action="load_recommendation"><i class="button-icon fas fa-pencil-alt"></i></div>

			<div 	class="wpeo-button button-square-50 button-grey delete action-delete"
			        data-id="<?php echo esc_attr( $recommendation->data['id'] ); ?>"
			        data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_recommendation' ) ); ?>"
			        data-action="delete_recommendation"
			        data-message-delete="<?php esc_attr_e( 'Êtes-vous sûr(e) de vouloir supprimer cette signalisation ?', 'digirisk' ); ?>"><i class="button-icon fas fa-trash"></i></div>
		</div>
	</div>
</div>
