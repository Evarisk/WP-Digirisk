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
}

global $eo_search; ?>

<div class="table-row item">
	<div class="table-cell tooltip red user-tooltip" aria-label="<?php esc_attr_e( 'Veuillez renseigner le participant', 'digirisk' ); ?>">
		<?php $eo_search->display( 'causerie_participants' ); ?>
	</div>

	<div class="table-cell table-100"></div>

	<div class="table-cell table-50 table-end">
		<div class="button-square-50 action-input add wpeo-button button-blue"
			data-loader="wpeo-table"
			data-parent="table-row"
			data-action="causerie_save_participant"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'causerie_save_participant' ) ); ?>"
			data-id="<?php echo esc_attr( $final_causerie->data['id'] ); ?>"
			data-namespace="digirisk"
			data-module="causerie"
			data-before-method="checkUserID">
			<i class="icon fa fa-plus"></i>
		</div>
	</div>
</div>
