<?php
/**
 * Formulaire pour importer des utilisateur.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.1.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

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
