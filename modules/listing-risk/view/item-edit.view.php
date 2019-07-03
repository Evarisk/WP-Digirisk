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
		<div class="action wpeo-gridlayout grid-1 grid-gap-0">
			<?php if ( 'picture' === $type ) : ?>
				<div class="wpeo-button button-square-50 button-main action-input add"
					data-type="photos"
					data-loader="table"
					data-parent="sheet-groupment-row">
					<i class="icon fa fa-plus"></i>
				</div>
			<?php endif; ?>

			<?php if ( 'corrective-task' === $type ) : ?>
				<div class="wpeo-button button-square-50 button-main action-input add"
				data-type="actions"
					data-loader="table"
					data-parent="sheet-groupment-row">
					<i class="icon fa fa-plus"></i>
				</div>
			<?php endif; ?>
		</div>
	</td>
</tr>
