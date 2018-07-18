<?php
/**
 * Affiches la liste des participants de la causerie.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="item">
	<td class="padding tooltip red user-tooltip" aria-label="<?php esc_attr_e( 'Veuillez renseigner le participant', 'digirisk' ); ?>">
		<input type="text"
					data-field="participant_id"
					data-type="user"
					placeholder=""
					class="digi-search"
					data-exclude="<?php echo esc_attr( $final_causerie->exclude_user_ids ); ?>"
					value="" />
		<input type="hidden" name="participant_id" value="" />
	</td>

	<td class="w50"></td>

	<td>
		<div class="w50 action-input add button blue"
			data-loader="table"
			data-parent="item"
			data-action="causerie_save_participant"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'causerie_save_participant' ) ); ?>"
			data-id="<?php echo esc_attr( $final_causerie->id ); ?>"
			data-namespace="digirisk"
			data-module="causerie"
			data-before-method="checkUserID">
			<i class="icon fa fa-plus"></i>
		</div>
	</td>
</tr>
