<?php
/**
 * Affichage d'un risque
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="risk-row">
	<td data-title="Ref." class="padding">
		<!-- La popup pour les actions correctives -->
		<?php \eoxia\View_Util::exec( 'digirisk', 'corrective_task', 'popup', array() ); ?>

		<span><strong><?php echo esc_html( $risk->modified_unique_identifier . ' - ' . $risk->evaluation->unique_identifier ); ?></span></strong>
	</td>
	<td data-title="Risque">
		<?php do_shortcode( '[digi-dropdown-categories-risk id="' . $risk->id . '" type="risk" display="view"]' ); ?>
	</td>
	<td data-title="Cot." class="w50">
		<?php do_shortcode( '[digi_evaluation_method risk_id=' . $risk->id . ' display="view"]' ); ?>
	</td>
	<td data-title="Photo" class="w50">
		<?php do_shortcode( '[wpeo_upload id="' . $risk->id . '" model_name="/digi/' . $risk->get_class() . '" single="false" field_name="image" ]' ); ?>
	</td>
	<td data-title="Commentaire" class="padding">
		<?php do_shortcode( '[digi_comment id="' . $risk->id . '" namespace="digi" type="risk_evaluation_comment" display="view"]' ); ?>
	</td>
	<td data-title="Action">
		<div class="action grid-layout w3">
			<div 	class="open-popup-ajax button light w50 task"
						data-parent="risk-row"
						data-target="popup"
						data-class="corrective-task"
						data-action="open_task"
						data-id="<?php echo esc_attr( $risk->id ); ?>"><i class="icon dashicons dashicons-schedule"></i></div>

			<!-- Editer un risque -->
			<div 	class="button light w50 edit action-attribute"
						data-id="<?php echo esc_attr( $risk->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_risk' ) ); ?>"
						data-loader="risk"
						data-action="load_risk"><i class="icon fa fa-pencil"></i></div>

			<div 	class="button light w50 delete action-delete"
						data-id="<?php echo esc_attr( $risk->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_risk' ) ); ?>"
						data-action="delete_risk"><i class="icon fa fa-times"></i></div>
		</div>
	</td>
</tr>
