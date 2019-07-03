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

	<div class="wpeo-button button-grey" data-type="link" data-link="no" style="margin-right: 8px;">
		<input class="tm_link_external" type="hidden" name="link_external" value="no"/>
		<input class="tm_save_backup" type="hidden" value=""/>
		<i class="fas fa-link tm-icon-import-from-url"></i>
	</div>
	<p class="tm-info-import-link" style="display : none">
		<?php esc_html_e( 'Please put a link (.txt)', 'task-manager' ); ?>
		<input type="text" name="tm_import_get_text" data-import="false" value="" style="width: 100%"/>
	</p>
</div>
<textarea name="content" style="width: 100%; height: 330px;" ><?= isset( $default_content ) ? esc_html( $default_content ) : '' ?></textarea>
