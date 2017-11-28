<?php
/**
 * Edition d'un accident
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="col add">
	<div class="cell padding w150"><?php esc_html_e( 'N/A', 'digirisk' ); ?></div>
	<div class="cell padding w200 tooltip red" aria-label="<?php esc_html_e( 'Ce champ est obligatoire', 'digirisk' ); ?>">
		<input type="text" data-field="accident[victim_identity_id]" data-type="user" placeholder="" class="digi-search" value="" dir="ltr">
		<input type="hidden" name="accident[victim_identity_id]" value="">
	</div>
	<div class="cell padding w150 group-date">
		<input type="text" class="mysql-date" style="width: 0px; padding: 0px; border: none;" name="accident[accident_date]" value="<?php echo esc_attr( $accident->accident_date['date_input']['date'] ); ?>" />
		<input type="text" class="date-time" placeholder="04/01/2017 00:00" value="<?php echo esc_html( $accident->accident_date['date_input']['fr_FR']['date_time'] ); ?>" />
	</div>
	<div class="cell padding w100 tooltip red" aria-label="<?php esc_html_e( 'Ce champ est obligatoire', 'digirisk' ); ?>">
		<div class="form-fields">
			<input type="text" class="search-parent" />
			<input type="hidden" name="accident[parent_id]" />
		</div>

		<div class="list-posts">
		</div>
	</div>
	<div class="cell padding tooltip red" aria-label="<?php esc_html_e( 'Ce champ est obligatoire', 'digirisk' ); ?>">
		<?php do_shortcode( '[digi_comment id="' . $accident->id . '" namespace="eoxia" type="comment" display="edit" display_date="false" display_user="false"]' ); ?>
	</div>
	<div class="cell w50" data-title="action">
		<div class="action grid-layout w3">
			<div class="action-input button w50 add disable"
				data-parent="col"
				data-namespace="digirisk"
				data-module="accident"
				data-before-method="checkDataBeforeAdd"
				data-action="edit_accident"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_accident' ) ); ?>"
				data-id="<?php echo esc_attr( $accident->id ); ?>"
				data-add="true"><i class="icon fa fa-plus"></i></div>
		</div>
	</div>
</div>
