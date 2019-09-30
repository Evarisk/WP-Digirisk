<?php
/**
 * Bloc d'édition des données de la société
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.3.3
 * @version 7.3.3
 * @copyright 2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>


<form class="wpeo-form">
	<input type="hidden" name="action" value="save_working_hours" />
	<input type="hidden" name="society[id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="address[post_id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="society[type]" value="<?php echo esc_attr( $element->data['type'] ); ?>" />
	<input type="hidden" name="legaldisplay_id" value="<?php echo esc_attr( $legal_display->data['id'] ); ?>" />
	<?php wp_nonce_field( 'save_working_hours' ); ?>

	<div class="wpeo-gridlayout grid-1 grid-gap-1">
		<table class="wpeo-table" style="margin-top: 20px">
			<thead>
				<tr>
					<th></th>
					<th><span><?php esc_html_e( 'Lundi', 'digirisk' ); ?></span></th>
					<th><span><?php esc_html_e( 'Mardi', 'digirisk' ); ?></span></th>
					<th><span><?php esc_html_e( 'Mercredi', 'digirisk' ); ?></span></th>
					<th><span><?php esc_html_e( 'Jeudi', 'digirisk' ); ?></span></th>
					<th><span><?php esc_html_e( 'Vendredi', 'digirisk' ); ?></span></th>
					<th><span><?php esc_html_e( 'Samedi', 'digirisk' ); ?></span></th>
					<th><span><?php esc_html_e( 'Dimanche', 'digirisk' ); ?></span></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><span><?php esc_html_e( 'Morning', 'digirisk' ); ?></span></td>
					<td class="padding"><span><input type="text" name="working_hour[monday_morning]" value="<?php echo $legal_display->data['working_hour']['monday_morning']; ?>" /></span></td>
					<td class="padding"><span><input type="text" name="working_hour[tuesday_morning]" value="<?php echo $legal_display->data['working_hour']['tuesday_morning']; ?>" /></span></td>
					<td class="padding"><span><input type="text" name="working_hour[wednesday_morning]" value="<?php echo $legal_display->data['working_hour']['wednesday_morning']; ?>" /></span></td>
					<td class="padding"><span><input type="text" name="working_hour[thursday_morning]" value="<?php echo $legal_display->data['working_hour']['thursday_morning']; ?>" /></span></td>
					<td class="padding"><span><input type="text" name="working_hour[friday_morning]" value="<?php echo $legal_display->data['working_hour']['friday_morning']; ?>" /></span></td>
					<td class="padding"><span><input type="text" name="working_hour[saturday_morning]" value="<?php echo $legal_display->data['working_hour']['saturday_morning']; ?>" /></span></td>
					<td class="padding"><span><input type="text" name="working_hour[sunday_morning]" value="<?php echo $legal_display->data['working_hour']['sunday_morning']; ?>" /></span></td>
				</tr>

				<tr>
					<td><span><?php esc_html_e( 'Afternoon', 'digirisk' ); ?></span></td>
					<td class="padding"><span><input type="text" name="working_hour[monday_afternoon]" value="<?php echo $legal_display->data['working_hour']['monday_afternoon']; ?>" /></span></td>
					<td class="padding"><span><input type="text" name="working_hour[tuesday_afternoon]" value="<?php echo $legal_display->data['working_hour']['tuesday_afternoon']; ?>" /></span></td>
					<td class="padding"><span><input type="text" name="working_hour[wednesday_afternoon]" value="<?php echo $legal_display->data['working_hour']['wednesday_afternoon']; ?>" /></span></td>
					<td class="padding"><span><input type="text" name="working_hour[thursday_afternoon]" value="<?php echo $legal_display->data['working_hour']['thursday_afternoon']; ?>" /></span></td>
					<td class="padding"><span><input type="text" name="working_hour[friday_afternoon]" value="<?php echo $legal_display->data['working_hour']['friday_afternoon']; ?>" /></span></td>
					<td class="padding"><span><input type="text" name="working_hour[saturday_afternoon]" value="<?php echo $legal_display->data['working_hour']['saturday_afternoon']; ?>" /></span></td>
					<td class="padding"><span><input type="text" name="working_hour[sunday_afternoon]" value="<?php echo $legal_display->data['working_hour']['sunday_afternoon']; ?>" /></span></td>
				</tr>
			</tbody>
		</table>

		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Permanentes', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="derogation_schedule[permanent]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['derogation_schedule']['permanent'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Occasionnelles', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="derogation_schedule[occasional]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['derogation_schedule']['occasional'] ); ?>" />
			</label>
		</div>

	</div>
	<div class="gridw-2" style="margin-top : 10px">
		<button class="wpeo-button button-main action-input alignright" data-parent="wpeo-form"><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></button>
	</div>
</form>
