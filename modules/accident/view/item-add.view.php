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

<div class="col">
	<div class="cell"></div>
	<div class="cell"></div>
	<div class="cell"></div>
	<div class="cell w100" data-title="action">
		<div class="action grid-layout w3">
			<div class="action-attribute button w50 blue add"
						data-action="edit_accident"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_accident' ) ); ?>"
						data-id="<?php echo esc_attr( $accident->id ); ?>"
						data-parent-id="<?php echo esc_attr( $main_society->id ); ?>"
						data-add="true"><i class="icon fa fa-plus"></i></div>
		</div>
	</div>
</div>
