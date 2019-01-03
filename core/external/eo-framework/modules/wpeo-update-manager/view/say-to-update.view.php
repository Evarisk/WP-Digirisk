<?php
/**
 * La vue affichant à l'utilisateur de mêttre à jour DigiRisk.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018 Eoxia
 * @package EO_Framework\EO_Update_Manager\View
 */

namespace task_manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-modal popup-update-manager active modal-active modal-force-display">
	<div class="modal-container">
		<div class="modal-header">
			<h2 class="title"><?php echo esc_html_e( 'Update required', 'eoxia' ); ?></h2>
		</div>
		<div class="modal-content">
			<p style="font-size: 1.4em; margin-bottom: 10px;"><?php echo esc_html( $title ); ?></p>
			<p style="font-size: 1.4em;"><?php esc_html_e( 'Warning! Stop the update process can destroy your data.', 'eoxia' ); ?></p>
		</div>

		<div class="modal-footer">
			<a class="button blue" href="<?php echo esc_attr( admin_url( 'admin.php?page=' . \eoxia\Config_Util::$init[ $namespace ]->update_page_url ) ); ?>">
				<span><?php esc_html_e( 'Start update', 'eoxia' ); ?></span>
			</a>
			<a class="back-update" href="<?php echo esc_attr( admin_url( 'index.php' ) ); ?>"><?php esc_html_e( 'Back', 'eoxia' ); ?></a>
		</div>
	</div>
</div>
