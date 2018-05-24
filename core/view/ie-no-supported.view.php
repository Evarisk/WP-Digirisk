<?php
/**
 * La vue affichant à l'utilisateur que IE n'est pas compatible avec DigiRisk.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018 Eoxia
 * @package DigiRisk
 */

namespace task_manager;

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

			<img src="https://media3.giphy.com/media/3o85xwSzDvuE1b2tW0/giphy.gif" alt="IE" />
		</div>

		<div class="modal-footer">
			<a class="back-update" href="<?php echo esc_attr( admin_url( 'index.php' ) ); ?>"><?php esc_html_e( 'Back', 'digirisk' ); ?></a>
		</div>
	</div>
</div>
