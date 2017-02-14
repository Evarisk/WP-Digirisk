<?php
/**
 * Ajoute le bouton pour exporter les risques au format CSV
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.6.0
 * @copyright 2015-2017 Evarisk
 * @package export_import
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

?>
<form action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>" method="POST" id="digi-export-csv-form" >
	<h3><?php esc_html_e( 'Exporter les risques au format CSV', 'digirisk' ); ?></h3>

	<div class="content">
		<input type="hidden" name="action" value="digi_export_csv_data" />
		<input type="hidden" name="offset" value="0" />
		<input type="hidden" name="number_risks" value="0" />
		<input type="hidden" name="filepath" value="" />
		<input type="hidden" name="url_to_file" value="" />
		<input type="hidden" name="filename" value="" />
		<?php /** Crtéation d'un nonce de sécurité pour le formulaire / Create a security nonce for the form */ wp_nonce_field( 'digi_export_csv_data' ); ?>
		<span class="digi-export-explanation" ><?php esc_html_e( 'Exportes tous les risques de votre Digirisk au format CSV', 'digirisk' ); ?></span>

		<progress value="0" max="100">0%</progress>
	</div>

	<button class="button blue" id="digi-export-csv-button" ><?php esc_html_e( 'Exporter', 'digirisk' ); ?></button>
</form>
