<?php
/**
 * Options avancée sur un risque
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2011-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     2.0.0
 */

namespace digirisk;

defined( 'ABSPATH' ) || exit; ?>

<div class="wpeo-form">

	<input type="hidden" name="to_society_id" />

	<div class="wpeo-dropdown dropdown-move-to">
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Déplacer vers GP ou UT', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input type="text" class="form-field" />
				<div class="wpeo-button button-blue button-square-50 action-input"
					data-risk-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
					data-action="move_risk_to"
					data-parent="wpeo-form"><?php esc_html_e( 'OK', 'digirisk' ); ?></div>
			</label>
		</div>

		<ul class="dropdown-content hidden" style="width: 482px;">
			<?php
			if ( ! empty( $societies ) ) :
				foreach ( $societies as $society ) :
					?>
					<li data-id="<?php echo esc_attr( $society->data['id'] ); ?>" class="dropdown-item">
						<span><?php echo esc_html( $society->data['unique_identifier'] . ' - ' . $society->data['title'] ); ?></span>
					</li>
					<?php
				endforeach;
			endif;
			?>
		</ul>
	</div>
</div>
