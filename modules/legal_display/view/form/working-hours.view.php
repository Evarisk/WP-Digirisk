<?php
/**
 * Horaires de travail
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package legal_display
 * @subpackage templates
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<h2><?php esc_html_e( 'Horaires de travail', 'digirisk' ); ?></h2>

<table class="table">
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
			<td class="padding"><span><input type="text" name="working_hour[monday_morning]" value="<?php echo $legal_display->working_hour['monday_morning']; ?>" /></span></td>
			<td class="padding"><span><input type="text" name="working_hour[tuesday_morning]" value="<?php echo $legal_display->working_hour['tuesday_morning']; ?>" /></span></td>
			<td class="padding"><span><input type="text" name="working_hour[wednesday_morning]" value="<?php echo $legal_display->working_hour['wednesday_morning']; ?>" /></span></td>
			<td class="padding"><span><input type="text" name="working_hour[thursday_morning]" value="<?php echo $legal_display->working_hour['thursday_morning']; ?>" /></span></td>
			<td class="padding"><span><input type="text" name="working_hour[friday_morning]" value="<?php echo $legal_display->working_hour['friday_morning']; ?>" /></span></td>
			<td class="padding"><span><input type="text" name="working_hour[saturday_morning]" value="<?php echo $legal_display->working_hour['saturday_morning']; ?>" /></span></td>
			<td class="padding"><span><input type="text" name="working_hour[sunday_morning]" value="<?php echo $legal_display->working_hour['sunday_morning']; ?>" /></span></td>
		</tr>

		<tr>
			<td><span><?php esc_html_e( 'Afternoon', 'digirisk' ); ?></span></td>
			<td class="padding"><span><input type="text" name="working_hour[monday_afternoon]" value="<?php echo $legal_display->working_hour['monday_afternoon']; ?>" /></span></td>
			<td class="padding"><span><input type="text" name="working_hour[tuesday_afternoon]" value="<?php echo $legal_display->working_hour['tuesday_afternoon']; ?>" /></span></td>
			<td class="padding"><span><input type="text" name="working_hour[wednesday_afternoon]" value="<?php echo $legal_display->working_hour['wednesday_afternoon']; ?>" /></span></td>
			<td class="padding"><span><input type="text" name="working_hour[thursday_afternoon]" value="<?php echo $legal_display->working_hour['thursday_afternoon']; ?>" /></span></td>
			<td class="padding"><span><input type="text" name="working_hour[friday_afternoon]" value="<?php echo $legal_display->working_hour['friday_afternoon']; ?>" /></span></td>
			<td class="padding"><span><input type="text" name="working_hour[saturday_afternoon]" value="<?php echo $legal_display->working_hour['saturday_afternoon']; ?>" /></span></td>
			<td class="padding"><span><input type="text" name="working_hour[sunday_afternoon]" value="<?php echo $legal_display->working_hour['sunday_afternoon']; ?>" /></span></td>
		</tr>
	</tbody>
</table>
