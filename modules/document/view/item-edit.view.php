<?php
/**
 * Template permettant de générer une fiche de groupement ou de poste.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="table-row documents-row sheet-groupment-row">

	<input type="hidden" name="action" value="<?php echo esc_attr( $action ); ?>" />
	<?php wp_nonce_field( $action ); ?>
	<input type="hidden" name="element_id" value="<?php echo esc_attr( $element->data['id'] ); ?>" />

	<div class="table-cell"><?php echo esc_html( $_this->message['generate'] ); ?></div>
	<div class="table-cell table-50 table-end">
		<div class="action">
			<div class="wpeo-button button-square-50 action-input add" data-loader="table-documents" data-parent="documents-row">
				<i class="icon fas fa-plus"></i>
			</div>
		</div>
	</div>
</div>
