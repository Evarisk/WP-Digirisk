<?php
/**
 * Vue permettant d'impoter un modèle DigiRisk.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="POST" id="digi-import-form" >
	<h3><?php _e( 'Import', 'digirisk' ); ?></h3>

	<div class="content">
		<?php echo esc_html_e( 'Cette fonctionnalitée est indisponible.', 'digirisk' ); ?>
		<!--<input type="hidden" name="action" value="digi_import_data" />
		<?php /** Crtéation d'un nonce de sécurité pour le formulaire / Create a security nonce for the form */ wp_nonce_field( 'digi_import_data' ); ?>
		<input type="hidden" name="element_id" value="<?php echo $element_id; ?>" />

		<span class="digi-import-explanation" ><?php _e( 'Don\'t start from scratch. Use a predefined template by importing it with the button below', 'digirisk' ); ?></span>
		<progress value="0" max="100">0%</progress>
		<input type="file" name="file" id="file" />
		<span class="digi-import-detail"></span>-->
	</div>

	<!--<label for="file" class="button blue" ><?php esc_html_e( 'Import Digirisk model (.ZIP)', 'digirisk' ); ?></label><br />-->

</form>
