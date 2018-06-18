<?php
/**
 * La vue affichant à l'utilisateur que IE n'est pas compatible avec DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-modal popup-ie active modal-active modal-force-display">
	<div class="modal-container">
		<div class="modal-header">
			<h2 class="title"><?php echo esc_html_e( 'IE n\'est pas compatible avec DigiRisk', 'digirisk' ); ?></h2>
		</div>
		<div class="modal-content">
			<p style="font-size: 1.4em; margin-bottom: 10px;"><?php esc_html_e( 'IE n\'est pas compatible avec DigiRisk', 'digirisk' ); ?></p>

			<p><a href="https://www.evarisk.com/document-unique-logiciel/documentation/introduction/pre-requis-digirisk/" target="_blank"><?php esc_html_e( 'Voir les navigateurs compatibles', 'digirisk' ); ?></a></p>
		</div>

		<div class="modal-footer">
			<a class="back-update" href="<?php echo esc_attr( admin_url( 'index.php' ) ); ?>"><?php esc_html_e( 'Back', 'digirisk' ); ?></a>
		</div>
	</div>
</div>
