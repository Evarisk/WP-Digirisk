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

<tr class="risk-row edit <?php echo esc_attr( 'method-' . $risk->evaluation_method->slug ); ?>">
	<input type="hidden" name="action" value="edit_risk" />
	<input type="hidden" name="page" value="all_risk" />
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $risk->parent_id ); ?>" />
	<input name="risk[id]" type="hidden" value="<?php echo esc_attr( $risk->id ); ?>" />
	<?php wp_nonce_field( 'edit_risk' ); ?>

	<td class="padding">
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-simple-risk-evaluation&establishment_id=' . $risk->parent_group->id ) ); ?>">
			<strong><?php echo esc_attr( $risk->parent_group->unique_identifier ); ?> -</strong>
			<span><?php echo esc_attr( $risk->parent_group->title ); ?></span>
		</a>
	</td>
	<td class="padding">
		<?php if ( ! empty( $risk->parent_workunit ) ) : ?>
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-simple-risk-evaluation&establishment_id=' . $risk->parent_id ) ); ?>">
			<strong><?php echo esc_attr( $risk->parent_workunit->unique_identifier ); ?> -</strong>
			<span><?php echo esc_attr( $risk->parent_workunit->title ); ?></span>
		</a>
		<?php else : ?>
			<p><?php esc_html_e( 'Aucune unité de travail', 'digirisk' ); ?></p>
		<?php endif; ?>
	</td>
	<td><?php do_shortcode( '[wpeo_upload id="' . $risk->id . '" model_name="/digi/' . $risk->get_class() . '" field_name="image" single="false" title="' . $risk->unique_identifier . ' - ' . $risk->evaluation->unique_identifier . '"]' ); ?></td>
	<td><?php do_shortcode( '[digi_evaluation_method risk_id=' . $risk->id . ']' ); ?></td>
	<td><?php echo esc_attr( $risk->unique_identifier ); ?> - <?php echo esc_attr( $risk->evaluation->unique_identifier ); ?></td>
	<td><?php do_shortcode( '[digi_dropdown_categories_risk id="' . $risk->id . '" type="risk" display="view"]' ); ?></td>
	<td><?php do_shortcode( '[digi_comment id="' . $risk->id . '" type="risk_evaluation_comment" display="edit"]' ); ?></td>

	<td>
		<input type="checkbox" name="can_update" />
		<a href="#" data-id="<?php echo esc_attr( $risk->id ); ?>"
								data-parent="risk-row"
								data-loader="table"
								class="edit-risk action-input fas fa-save" aria-hidden="true" style="display: none;" ></a>
	</td>

</tr>
