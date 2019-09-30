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


	<div class="" style="float:left">
		<span class="wpeo-button button-blue digi-import-execute-run"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'execute_git_txt' ) ); ?>">
			<i class="fas fa-play"></i>
			<span><?php esc_html_e( 'Executer', 'digirisk' ); ?></span>
		</span>
	</div>
	<div class="digi-view-execute-hide">
		<div class="wpeo-button button-grey button-uppercase">
			<span><?php esc_html_e( 'Cancel', 'task-manager' ); ?></span>
		</div>
	</div>
