<?php
/**
 * Template contenant le formulaire pour ajouter un accident.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.3.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

global $eo_search; ?>

<div class="col add">
	<div class="cell padding w150"></div>
	<div class="cell padding w200 tooltip red" aria-label="<?php esc_html_e( 'This field is required', 'digirisk' ); ?>">
		<?php $eo_search->display( 'accident_user' ); ?>
	</div>
	<div class="cell group-date w150" data-time="true">
		<input type="hidden" class="mysql-date" name="accident[accident_date]" value="<?php echo esc_attr( $accident->data['accident_date']['raw'] ); ?>" />
		<input type="text" class="date" value="<?php echo esc_html( $accident->data['accident_date']['rendered']['date'] ); ?>" />
	</div>
	<div class="cell padding w200 tooltip red" aria-label="<?php esc_html_e( 'This field is required', 'digirisk' ); ?>">
		<?php $eo_search->display( 'accident_post' ); ?>
	</div>
	<div class="cell padding tooltip red" aria-label="<?php esc_html_e( 'This field is required', 'digirisk' ); ?>">
		<?php do_shortcode( '[digi_comment id="' . $accident->data['id'] . '" namespace="eoxia" type="comment" display="edit" display_date="false" display_user="false"]' ); ?>
	</div>
	<div class="cell w50" data-title="action">
		<div class="action">
			<div class="action-input wpeo-button button-square-50 add button-disable"
				data-parent="col"
				data-namespace="digirisk"
				data-module="accident"
				data-before-method="checkDataBeforeAdd"
				data-action="edit_accident"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_accident' ) ); ?>"
				data-id="<?php echo esc_attr( $accident->data['id'] ); ?>"
				data-add="true"><i class="button-icon fas fa-plus"></i></div>
		</div>
	</div>
</div>
