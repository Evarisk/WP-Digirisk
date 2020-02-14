<?php
/**
 * Gestion du formulaire pour générer un fichier CSV sur les statisques.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.5.3
 * @version 7.5.3
 * @copyright 2015-2020 Evarisk
 * @package DigiRisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="sheet-groupment-row">
	<input type="hidden" name="action" value="export_csv_file" />
	<?php wp_nonce_field( 'export_csv_file' ); ?>
	<input type="hidden" name="id" value="<?php echo esc_attr( $id ); ?>" />

	<td></td>
	<td></td>
	<td>
		<div class="action wpeo-gridlayout grid-1 grid-gap-0">
			<div class="wpeo-button button-square-50 button-main action-input add"
				data-loader="table"
				data-parent="sheet-groupment-row">
				<i class="icon fa fa-plus"></i>
			</div>
		</div>
	</td>
</tr>
