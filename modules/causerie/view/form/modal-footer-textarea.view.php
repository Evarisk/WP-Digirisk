<?php
/**
 * Footer de la modal Textarea
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2019 Eoxia
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

	<?php  ?>
	<div class="digi-display-view-git" style="float:left">
		<span class="wpeo-button button-blue digi-content-git" style="display : none">
			<input type="hidden" name="contentgit"/>
			<i class="fas fa-file-import"></i>
			<span><?php esc_html_e( 'GIT import to txt', 'digirisk' ); ?></span>
		</span>
	</div>
	<div class="digi-button-import">
		<div class="wpeo-button button-grey button-uppercase modal-close">
			<span><?php esc_html_e( 'Cancel', 'task-manager' ); ?></span>
		</div>
		<a class="wpeo-button button-main button-uppercase action-input"
			data-parent="digi-import-causeries"
			data-action="digi_import_causeries"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'digi_import_causeries' ) ); ?>" >
			<span><?php esc_html_e( 'Import', 'digirisk' ); ?></span>
		</a>
	</div>
