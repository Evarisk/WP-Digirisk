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

<div class="table-row statistics-row">
	<input type="hidden" name="action" value="export_csv_file" />
	<?php wp_nonce_field( 'export_csv_file' ); ?>
	<input type="hidden" name="id" value="<?php echo esc_attr( $id ); ?>" />

	<div class="table-cell table-50 table-end">
		<div class="action">
			<div class="wpeo-button button-square-50 button-main action-input add"
				data-loader="table-statistics"
				data-parent="statistics-row">
				<i class="icon fa fa-plus"></i>
			</div>
		</div>
	</div>
</div>
