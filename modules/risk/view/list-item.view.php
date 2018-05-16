<?php
/**
 * Affichage d'un risque
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

<tr class="risk-row <?php echo esc_attr( 'method-' . $risk->data['evaluation_method']->data['slug'] ); ?>" data-id="<?php echo esc_attr( $risk->data['id'] ); ?>">
	<td data-title="Ref." class="padding">
		<!-- La popup pour les actions correctives -->
		<?php \eoxia\View_Util::exec( 'digirisk', 'corrective_task', 'popup', array() ); ?>

		<span>
			<strong>
				<?php echo esc_html( $risk->data['modified_unique_identifier'] . ' - ' . $risk->data['evaluation']->data['unique_identifier'] ); ?>
			</strong>
		</span>
	</td>
	<td data-title="Risque">
		<?php do_shortcode( '[digi_dropdown_categories_risk id="' . $risk->data['id'] . '" type="risk" display="view"]' ); ?>
	</td>
	<td data-title="Cot." class="w50">
		<?php Risk_Evaluation_Class::g()->display( $risk ); ?>
	</td>
	<td data-title="Photo" class="w50">
		<?php do_shortcode( '[wpeo_upload id="' . $risk->data['id'] . '" model_name="' . $risk->get_class() . '" single="false" field_name="image" title="' . $risk->data['modified_unique_identifier'] . '" ]' ); ?>
	</td>
	<td data-title="Commentaire" class="padding">
		<?php do_shortcode( '[digi_comment id="' . $risk->data['id'] . '" namespace="digi" type="risk_evaluation_comment" display="view"]' ); ?>
	</td>
	<td data-title="Action">
		<div class="action grid-layout w3">
			<div 	class="open-popup-ajax button light w50 task"
						data-parent="risk-row"
						data-target="popup"
						data-class="corrective-task"
						data-action="open_task"
						data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"><i class="icon dashicons dashicons-schedule"></i></div>

			<!-- Editer un risque -->
			<div 	class="button light w50 edit action-attribute"
						data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_risk' ) ); ?>"
						data-loader="risk"
						data-action="load_risk"><i class="icon fas fa-pencil"></i></div>

			<div 	class="button light w50 delete action-delete"
						data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_risk' ) ); ?>"
						data-action="delete_risk"><i class="icon far fa-times"></i></div>
		</div>
	</td>
</tr>
