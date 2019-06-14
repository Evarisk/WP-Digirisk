<?php
/**
 * La vue d'une tâche dans le backend.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.7.0
 * @version 1.7.0
 * @copyright 2015-2018 Eoxia
 * @package Task_Manager\Import
 */

namespace task_manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<div class="digi-import-add-keyword" style="display : flex">
	<div class="wpeo-button button-blue" data-type="causerie" style="margin-right: 8px;">
		<i class="button-icon fas fa-plus-circle"></i>
		<span><?php esc_html_e( 'Causerie', 'digirisk' ); ?></span>
	</div>
	<div class="wpeo-button button-blue" data-type="description" style="margin-right: 8px;">
		<i class="button-icon fas fa-plus-circle"></i>
		<span><?php esc_html_e( 'Description', 'digirisk' ); ?></span>
	</div>
	<div class="wpeo-button button-blue" data-type="media" style="margin-right: 8px;">
		<i class="button-icon fas fa-plus-circle"></i>
		<span><?php esc_html_e( 'Média', 'digirisk' ); ?></span>
	</div>
	<?php do_shortcode( '[digi_dropdown_categories_risk type="causerie" display="edit"]' ); ?>
</div>
<textarea name="content" style="width: 100%; height: 330px;" ><?= isset( $default_content ) ? esc_html( $default_content ) : '' ?></textarea>
