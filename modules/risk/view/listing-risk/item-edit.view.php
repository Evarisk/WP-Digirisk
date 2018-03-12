<?php
/**
 * Gestion du formulaire pour générer un listing de risque.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="sheet-groupment-row">
	<input type="hidden" name="action" value="generate_listing_risk" />
	<?php wp_nonce_field( 'generate_listing_risk' ); ?>
	<input type="hidden" name="element_id" value="<?php echo esc_attr( $element_id ); ?>" />

	<td></td>
	<td></td>
	<td>
		<div class="action grid-layout w2">
			<div class="w50 action-input add button blue tooltip hover"
				data-type="photos"
				aria-label="<?php esc_attr_e( 'Avec les photos des risques', 'digirisk' ); ?>"
				data-loader="table"
				data-parent="sheet-groupment-row">
				<i class="icon fa fa-file-image-o"></i>
			</div>
			<div class="w50 action-input add button blue tooltip hover"
			data-type="actions"
				aria-label="<?php esc_attr_e( 'Avec les actions correctives', 'digirisk' ); ?>"
				data-loader="table"
				data-parent="sheet-groupment-row">
				<i class="icon fa fa-file"></i>
			</div>
		</div>
	</td>
</tr>
