<?php
/**
 * Vue permettant d'impoter un modèle DigiRisk.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.9
 * @version 6.4.4
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<form action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>" method="POST" id="digi-import-form" >
	<h3><?php esc_html_e( 'Importer', 'digirisk' ); ?></h3>

	<div class="content">
		<input type="hidden" name="action" value="digi_import_data" />
		<?php wp_nonce_field( 'digi_import_data' ); ?>
		<input type="hidden" name="element_id" value="<?php echo esc_attr( $element_id ); ?>" />

		<span class="digi-import-explanation" ><?php esc_attr_e( 'Ne commencez pas de zéro! Importez un modèle prédéfini en cliquant sur le bouton ci-dessous.', 'digirisk' ); ?></span>
		<progress value="0" max="100">0%</progress>
		<input type="file" name="file" id="file" />
		<span class="digi-import-detail"></span>
	</div>

	<label for="file" class="button blue" ><?php esc_html_e( 'Importer un modèle (.ZIP)', 'digirisk' ); ?></label><br />

</form>
