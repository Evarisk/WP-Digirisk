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

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<div class="digi-import-add-keyword" style="display : flex; margin-bottom: 8px; float:left">
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

	<div class="wpeo-form import-git-input">
	    <div class="form-element">
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-globe"></i></span>
				<input type="text" class="form-field">
			</label>
		</div>
	</div>
	<div class="wpeo-button button-blue import-git-button"
	data-action="ia_import_txt_from_url"
	data-action="<?php echo esc_attr( wp_create_nonce( 'ia_import_txt_from_url' ) ); ?>">
		<i class="fas fa-2x fa-file-import" style="margin-top:-2px"></i>
	</div>

</div>

<textarea name="content" style="width: 100%; min-height: 400px;" >
	<?= isset( $default_content ) ? esc_html( $default_content ) : '' ?>
</textarea>
