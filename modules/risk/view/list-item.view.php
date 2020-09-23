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

<div class="table-row risk-row <?php echo esc_attr( 'method-' . $risk->data['evaluation_method']->data['slug'] ); ?>" data-id="<?php echo esc_attr( $risk->data['id'] ); ?>">
	<div data-title="Ref." class="table-cell table-75 cell-reference">
		<!-- La popup pour les actions correctives -->
		<?php \eoxia\View_Util::exec( 'digirisk', 'corrective_task', 'popup', array() ); ?>

		<span>
			<strong>
				<?php echo esc_html( $risk->data['unique_identifier'] . ' - ' . $risk->data['evaluation']->data['unique_identifier'] ); ?>
			</strong>
		</span>
	</div>
	<div class="table-cell table-50 cell-risk" data-title="Risque">
		<?php do_shortcode( '[digi_dropdown_categories_risk id="' . $risk->data['id'] . '" type="risk" display="view" category_risk_id="' . end( $risk->data['taxonomy'][ Risk_Category_Class::g()->get_type() ] ) . '"]' ); ?>
	</div>
	<div class="table-cell table-50 cell-cotation" data-title="Cot.">
		<?php Risk_Evaluation_Class::g()->display( $risk ); ?>
	</div>
	<div class="table-cell table-50 cell-photo" data-title="Photo">
		<?php echo do_shortcode( '[wpeo_upload id="' . $risk->data['id'] . '" model_name="' . $risk->get_class() . '" single="false" field_name="image" title="' . $risk->data['unique_identifier'] . '" ]' ); ?>
	</div>
	<div class="table-cell cell-comment" data-title="Commentaire" class="padding">
		<?php do_shortcode( '[digi_comment id="' . $risk->data['id'] . '" namespace="digi" type="risk_evaluation_comment" display="view"]' ); ?>
	</div>
	<div class="table-cell cell-action table-150 table-padding-0 table-end" data-title="Action">
		<div class="action wpeo-gridlayout grid-gap-0 grid-3">
			<!-- Editer un risque -->
			<div 	class="wpeo-button button-square-50 button-transparent w50 edit action-attribute"
					data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_risk' ) ); ?>"
					data-loader="table-risk"
					data-action="load_risk"><i class="button-icon fas fa-pencil-alt"></i></div>

			<div    class="wpeo-modal-event wpeo-button button-square-50 button-transparent w50 action-corrective"
			        data-parent="risk-row"
			        data-class="wpeo-wrap corrective-task tm-wrap"
			        data-action="open_task"
			        data-title="<?php echo 'Les actions correctives du risque: ' . $risk->data['unique_identifier']; ?>"
			        data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"><i class="fas fa-list-ul fa-fw"></i></div>

			<!-- Options avancées -->
			<div class="wpeo-dropdown dropdown-right risk-options">
				<div class="button-transparent wpeo-button button-square-50 dropdown-toggle"><i class="icon fas fa-ellipsis-v"></i></div>
				<div class="dropdown-content" style="width: 500px;">
					<li class="dropdown-item action-delete"
					    data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
					    data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_risk' ) ); ?>"
					    data-message-delete="<?php esc_attr_e( 'Êtes-vous sûr(e) de vouloir supprimer ce risque ?', 'digirisk' ); ?>"
					    data-action="delete_risk">

						<i class="far fa-trash-alt fa-fw"></i> <?php esc_html_e( 'Supprimer', 'digirisk' ); ?>
					</li>
					<?php
					\eoxia\View_Util::exec( 'digirisk', 'risk', 'options', array(
						'risk'      => $risk,
						'societies' => $societies,
					) );
					?>
				</div>
			</div>
		</div>
	</div>
</div>
