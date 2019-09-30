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
				<?php echo esc_html( $risk->data['unique_identifier'] . ' - ' . $risk->data['evaluation']->data['unique_identifier'] ); ?>
			</strong>
		</span>
	</td>
	<td data-title="Risque">
		<?php do_shortcode( '[digi_dropdown_categories_risk id="' . $risk->data['id'] . '" type="risk" display="view" category_risk_id="' . end( $risk->data['taxonomy'][ Risk_Category_Class::g()->get_type() ] ) . '"]' ); ?>
	</td>
	<td data-title="Cot." class="w50">
		<?php Risk_Evaluation_Class::g()->display( $risk ); ?>
	</td>
	<td data-title="Photo" class="w50">
		<?php echo do_shortcode( '[wpeo_upload id="' . $risk->data['id'] . '" model_name="' . $risk->get_class() . '" single="false" field_name="image" title="' . $risk->data['unique_identifier'] . '" ]' ); ?>
	</td>
	<td data-title="Commentaire" class="padding">
		<?php do_shortcode( '[digi_comment id="' . $risk->data['id'] . '" namespace="digi" type="risk_evaluation_comment" display="view"]' ); ?>
	</td>
	<td data-title="Action">
		<div class="action wpeo-gridlayout grid-gap-0 grid-4">
			<div 	class="wpeo-modal-event wpeo-button button-transparent button-square-50"
					data-parent="risk-row"
					data-class="wpeo-wrap corrective-task"
					data-action="open_task"
					data-title="<?php echo 'Les actions correctives du risque: ' . $risk->data['unique_identifier']; ?>"
					data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"><i class="button-icon fas fa-list-ul"></i></div>

			<!-- Editer un risque -->
			<div 	class="wpeo-button button-square-50 button-transparent w50 edit action-attribute"
						data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_risk' ) ); ?>"
						data-loader="risk"
						data-action="load_risk"><i class="button-icon fas fa-pencil-alt"></i></div>

			<!-- Supprimer un risque -->
			<div 	class="wpeo-button button-square-50 button-transparent w50 delete action-delete"
						data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_risk' ) ); ?>"
						data-message-delete="<?php esc_attr_e( 'Êtes-vous sûr(e) de vouloir supprimer ce risque ?', 'digirisk' ); ?>"
						data-action="delete_risk"><i class="button-icon fas fa-times"></i></div>

			<div class="wpeo-dropdown dropdown-right risk-options">
				<div class="button-transparent wpeo-button button-square-50 dropdown-toggle"><i class="icon fas fa-ellipsis-v"></i></div>
				<div class="dropdown-content" style="width: 500px;">
					<?php
					\eoxia\View_Util::exec( 'digirisk', 'risk', 'options', array(
						'risk'      => $risk,
						'societies' => $societies,
					) );
					?>
				</div>
			</div>
		</div>
	</td>
</tr>
