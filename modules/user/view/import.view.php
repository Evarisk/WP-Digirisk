<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du squelette du formulaire permettant de lancer l'importation des utilisateurs
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.1.5.5
 * @copyright 2015-2016 Evarisk
 * @package user
 * @subpackage view
 */
?>
<form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="POST" id="digi-import-form" >
	<h3><?php _e( 'Import', 'digirisk' ); ?></h3>

	<!-- <div class="content">
		<input type="hidden" name="action" value="digi_import_user" />
		<?php /** Crtéation d'un nonce de sécurité pour le formulaire / Create a security nonce for the form */ wp_nonce_field( 'digi_import_user' ); ?>

		<span class="digi-import-explanation" ><?php _e( 'Import all your users in your CSV files', 'digirisk' ); ?></span>
		<progress value="0" max="100">0%</progress>
		<span class="digi-import-detail"></span>
		<input type="file" name="file" id="file" />
	</div>

	<label for="file" class="wp-digi-bton-first" ><?php _e( 'Import Digirisk user (.CSV)', 'digirisk' ); ?></label><br /> -->
	<p>Indisponible</p>

</form>
