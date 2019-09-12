<?php
/**
 * Affichage principale pour définir les préfix des odt Causeries / Plan de prévention / Permis de feu
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.3.5
 * @copyright 2019 Evarisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="table">
	<thead>
		<tr>
			<th class="padding"><?php esc_html_e( 'Element', 'digirisk' ); ?></th>
			<th class="padding"><?php esc_html_e( 'Prefix', 'digirisk' ); ?></th>
			<th class="w100 padding"><?php esc_html_e( 'Accéder', 'digirisk' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $prefix as $element ): ?>
			<tr>
				<td class="padding">
					<span><?php echo esc_attr( $element[ 'title' ] ); ?></span>
				</td>
				<td class="padding">
					<input type="text" name="<?php echo esc_attr( $element[ 'element' ] ); ?>" value="<?php echo esc_attr( $element[ 'value' ] ); ?>" />
				</td>
				<td class="w100 padding wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Accéder à la page', 'digirisk' ); ?>" style="text-align: center;">
					<a href="<?php echo esc_attr( $element[ 'page' ] ); ?>">
						<div class="wpeo-button button-blue">
							<i class="fas fa-share"></i>
						</div>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<a href="#" class="margin wpeo-button button-disable action-input save-prefix"
data-action="save_prefix_settings_digirisk"
data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_prefix_settings_digirisk' ) ); ?>"
data-parent="tab-content"
style="float: right; margin-top: 10px;">
	<?php esc_html_e( 'Enregistrer', 'digirisk' ); ?>
</a>

<div class="wpeo-notification notification-green prefix-response-success"
style="opacity:1; display:none; bottom:auto; cursor : pointer; pointer-events : auto;position: inherit; margin-top: 1em; max-width: 250px;">
	<i class="notification-icon fas fa-check"></i>
	<div class="notification-title"></div>
	<div class="notification-close"><i class="fas fa-times"></i></div>
</div>
