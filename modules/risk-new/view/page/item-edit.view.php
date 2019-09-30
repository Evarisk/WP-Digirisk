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

<tr class="risk-row edit <?php echo esc_attr( 'method-' . $risk->data['evaluation_method']->data['slug'] ); ?>" data-id="<?php echo esc_attr( $risk->data['id'] ); ?>">
	<input type="hidden" name="action" value="edit_risk" />
	<input type="hidden" name="page" value="all_risk" />
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $risk->data['parent_id'] ); ?>" />
	<input name="risk[id]" type="hidden" value="<?php echo esc_attr( $risk->data['id'] ); ?>" />
	<?php wp_nonce_field( 'edit_risk' ); ?>

	<td class="padding">
		<?php if ( ! empty( $risk->data['parent'] ) ) : ?>
			<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-simple-risk-evaluation&society_id=' . $risk->data['parent_id'] ) ); ?>">
				<strong><?php echo esc_attr( $risk->data['parent']->data['unique_identifier'] ); ?> -</strong>
				<span><?php echo esc_attr( $risk->data['parent']->data['title'] ); ?></span>
			</a>
		<?php endif; ?>
	</td>
	<td><?php do_shortcode( '[wpeo_upload id="' . $risk->data['id'] . '" model_name="/digi/Risk_Class" field_name="image" single="false" title="' . $risk->data['unique_identifier'] . ' - ' . $risk->data['evaluation']->data['unique_identifier'] . '"]' ); ?></td>
	<td><?php do_shortcode( '[digi_dropdown_evaluation_method risk_id=' . $risk->data['id'] . ']' ); ?></td>
	<td><?php echo esc_attr( $risk->data['unique_identifier'] ); ?> - <?php echo esc_attr( $risk->data['evaluation']->data['unique_identifier'] ); ?></td>
	<td><?php do_shortcode( '[digi_dropdown_categories_risk id="' . $risk->data['id'] . '" category_risk_id="' . $risk->data['risk_category']->data['id'] . '" type="risk" display="view"]' ); ?></td>
	<td><?php do_shortcode( '[digi_comment id="' . $risk->data['id'] . '" type="risk_evaluation_comment" display="edit"]' ); ?></td>

	<td>
		<input type="checkbox" name="can_update" />
		<a href="#" data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
								data-parent="risk-row"
								data-loader="table"
								class="edit-risk action-input fas fa-save" aria-hidden="true" style="display: none;" ></a>
	</td>

</tr>
