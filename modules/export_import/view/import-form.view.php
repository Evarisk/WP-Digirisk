<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du squelette du formulaire permettant de lancer l'export des données / Template file for the form allowing to export datas
 *
 * @author Alexandre Techer <dev@evarisk.com>
 * @version 6.1.5.5
 * @copyright 2015-2016 Evarisk
 * @package export_import
 * @subpackage view
 */
?>
<form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="POST" id="digi-import-form" >
	<h3><?php _e( 'Import', 'digirisk' ); ?></h3>

	<div class="content">
		<input type="hidden" name="action" value="digi_import_data" />
		<?php /** Crtéation d'un nonce de sécurité pour le formulaire / Create a security nonce for the form */ wp_nonce_field( 'digi_import_data' ); ?>
		<input type="hidden" name="element_id" value="<?php echo $element_id; ?>" />

		<span class="digi-import-explanation" ><?php _e( 'Don\'t start from scratch. Use a predefined template by importing it with the button below', 'digirisk' ); ?></span>
		<progress value="0" max="100">0%</progress>
		<input type="file" name="file" id="file" />
		<span class="digi-import-detail"></span>
	</div>

	<label for="file" class="button blue" ><?php _e( 'Import Digirisk model (.ZIP)', 'digirisk' ); ?></label><br />

</form>
