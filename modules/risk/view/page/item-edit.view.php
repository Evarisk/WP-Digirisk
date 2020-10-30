<?php
/**
 * Édition d'un risque.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.3
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="table-row listing-risk risk-row edit" data-id="<?php echo esc_attr( $risk->data['id'] ); ?>">
	<input type="hidden" name="action" value="edit_risk" />
	<input type="hidden" name="page" value="all_risk" />
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $risk->data['parent_id'] ); ?>" />
	<input type="hidden" name="can_update" value="true"/>
	<input name="id" type="hidden" value="<?php echo esc_attr( $risk->data['id'] ); ?>" />
	<input name="risk[id]" type="hidden" value="<?php echo esc_attr( $risk->data['id'] ); ?>" />
	<?php wp_nonce_field( 'edit_risk' ); ?>

	<div class="table-cell table-150">
		<?php if ( ! empty( $risk->data['parent'] ) ) : ?>
			<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-du&society_id=' . $risk->data['parent_id'] ) ); ?>">
				<strong><?php echo esc_attr( $risk->data['parent']->data['unique_identifier'] ); ?> -</strong>
				<span><?php echo esc_attr( $risk->data['parent']->data['title'] ); ?></span>
			</a>
		<?php endif; ?>
	</div>
	<div class="table-cell table-50"><?php do_shortcode( '[wpeo_upload id="' . $risk->data['id'] . '" model_name="/digi/Risk_Class" field_name="image" single="false" title="' . $risk->data['unique_identifier'] . ' - ' . $risk->data['evaluation']->data['unique_identifier'] . '"]' ); ?></div>
	<div class="table-cell table-50"><?php do_shortcode( '[digi_dropdown_evaluation_method risk_id=' . $risk->data['id'] . ']' ); ?></div>
	<div class="table-cell table-50"><?php echo esc_attr( $risk->data['unique_identifier'] ); ?> - <?php echo esc_attr( $risk->data['evaluation']->data['unique_identifier'] ); ?></div>
	<div class="table-cell table-50"><?php do_shortcode( '[digi_dropdown_categories_risk id="' . $risk->data['id'] . '" category_risk_id="' . $risk->data['risk_category']->data['id'] . '" type="risk" display="view"]' ); ?></div>
	<div class="table-cell"><?php do_shortcode( '[digi_comment id="' . $risk->data['id'] . '" type="risk_evaluation_comment" display="edit"]' ); ?></div>
	<div class="table-cell"><?php do_shortcode( '[digi_comment id="' . $risk->data['id'] . '" type="risk_evaluation_comment" display="edit"]' ); ?></div>
	<div class="wpeo-modal-event wpeo-button button-square-50 button-transparent w50 action-corrective"
		data-parent="risk-row"
		data-class="wpeo-wrap corrective-task tm-wrap"
		data-action="open_task"
		data-title="<?php echo 'Les actions correctives du risque: ' . $risk->data['unique_identifier']; ?>"
		data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"><i class="fas fa-list-ul fa-fw"></i>
	</div>
	<div class="table-cell table-50 table-end">
		<input type="checkbox" name="can_update" />
		<a href="#" data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
		   data-parent="listing-risk"
		   data-loader="table-listing-risk"
		   class="edit-risk action-input fas fa-save" aria-hidden="true" style="display: none;" ></a>
	</div>
</div>
