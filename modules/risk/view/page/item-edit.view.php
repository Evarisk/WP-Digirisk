<?php
/**
 * Affiches un risque
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.6.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<tr class="risk-row edit">
	<input type="hidden" name="action" value="edit_risk" />
	<input type="hidden" name="page" value="all_risk" />
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $risk->parent_id ); ?>" />
	<input name="risk[id]" type="hidden" value="<?php echo esc_attr( $risk->id ); ?>" />
	<?php wp_nonce_field( 'edit_risk' ); ?>

	<td class="padding">
		<?php echo do_shortcode( '[digi_evaluation_method_evarisk risk_id=' . $risk->id . ' type="risk"]' ); ?>

		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-simple-risk-evaluation&groupment_id=' . $risk->parent_group->id ) ); ?>">
			<strong><?php echo esc_attr( $risk->parent_group->unique_identifier ); ?> -</strong>
			<span><?php echo esc_attr( $risk->parent_group->title ); ?></span>
		</a>
	</td>
	<td class="padding">
		<?php if ( ! empty( $risk->parent_workunit ) ) : ?>
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-simple-risk-evaluation&groupment_id=' . $risk->parent_group->id . '&workunit_id=' . $risk->parent_workunit->id ) ); ?>">
			<strong><?php echo esc_attr( $risk->parent_workunit->unique_identifier ); ?> -</strong>
			<span><?php echo esc_attr( $risk->parent_workunit->title ); ?></span>
		</a>
		<?php else : ?>
			<p><?php esc_html_e( 'Aucune unité de travail', 'digirisk' ); ?></p>
		<?php endif; ?>
	</td>
	<td><?php do_shortcode( '[eo_upload_button id="' . $risk->id . '" type="risk"]' ); ?></td>
	<td><?php do_shortcode( '[digi_evaluation_method risk_id=' . $risk->id . ']' ); ?></td>
	<td><?php echo esc_attr( $risk->unique_identifier ); ?> - <?php echo esc_attr( $risk->evaluation->unique_identifier ); ?></td>
	<td><?php do_shortcode( '[dropdown_danger id="' . $risk->id . '" type="risk" display="view"]' ); ?></td>
	<td><?php do_shortcode( '[digi_comment id="' . $risk->id . '" type="risk_evaluation_comment" display="edit"]' ); ?></td>

	<td>
		<input type="checkbox" name="can_update" />
		<a href="#" data-id="<?php echo esc_attr( $risk->id ); ?>"
								data-parent="risk-row"
								data-loader="table"
								class="edit-risk action-input fa fa-floppy-o" aria-hidden="true" style="display: none;" ></a>
	</td>

</tr>
