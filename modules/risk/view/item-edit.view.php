<?php
/**
 * Edition d'un risque
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<tr>
	<td class="padding"></td>
	<td>
		<?php do_shortcode( '[dropdown_danger id="' . $risk->id . '" type="risk" display="' . ( ( $risk->id !== 0 ) ? "view" : "edit" ) . '"]' ); ?>
	<td class="w50">
		<?php do_shortcode( '[digi_evaluation_method risk_id=' . $risk->id . ']' ); ?>
	</td>
	<td class="w50">
		<?php do_shortcode( '[eo_upload_button id="' . $risk->id . '" type="risk"]' ); ?>
	</td>
	<td class="full padding">
		<?php do_shortcode( '[digi_comment id="' . $risk->id . '" type="risk_evaluation_comment" display="edit"]' ); ?>
	</td>
	<td>
		<div class="action grid w1">
			<div class="button w50 blue add"><i class="icon fa fa-plus"></i></div>
		</div>
	</td>
</tr>
