<?php
/**
 * Footer de la modal GIT
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2019 Eoxia
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

	<div class="wpeo-notice notice-success digi-info-git-success"
	style="display : none; padding : 10px; margin : 0; float:left; width: 90%">
		<div class="notice-content">
			<div class="notice-title"></div>
		</div>
		<div class="notice-close"><i class="fas fa-times"></i></div>
	</div>

	<div class="digi-footer-git-import">

		<span style="float :left">
			<i><?php esc_html_e( 'Import', 'digirisk' ); ?></i>
		</span>
		<input class="wpeo-tooltip-event"  type="text" name="content" style="width : 80%; float: left;"
		aria-label="<?php esc_html_e( 'Mettez le lien d\'un repertoire GitHub', 'digirisk' ); ?>"/>

		<div class="action-input wpeo-button button-main" style="float:right;"
		data-action="<?php echo esc_attr( 'get_text_from_url' ); ?>"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'get_text_from_url' ) ); ?>"
		data-parent="modal-footer-view-git"
		data-loader="wpeo-button">
			<i class="fas fa-download"></i>
		</div>

	</div>

	<div class="digi-footer-git-display" style="display : none; float: right">
		<div class="wpeo-button button-blue">
			<i class="fas fa-angle-left"></i>
		</div>
	</div>




	<div class="wpeo-notice notice-error digi-info-git-error"
	style="display : none; padding : 10px; margin : 0;">
		<div class="notice-content">
			<div class="notice-title"></div>
		</div>
		<div class="notice-close"><i class="fas fa-times"></i></div>
	</div>
