<?php
/**
 * Gestion du formulaire pour générer un DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.1.9.0
 * @copyright 2015-2016 Evarisk
 * @package document
 * @subpackage view
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<li class='wp-digi-list-item wp-digi-risk-item'>
	<input type="hidden" name="action" value="generate_duer" />
	<?php wp_nonce_field( 'callback_ajax_generate_duer' ); ?>
	<input type="hidden" name="element_id" value="<?php echo esc_attr( $element_id ); ?>" />

	<span></span>
	<span class="padded"><input type="text" class="eva-date" value="<?php echo esc_attr( mysql2date( 'd/m/Y', current_time( 'mysql', 0 ), true ) ); ?>" name="dateDebutAudit" /></span>
	<span class="padded"><input type="text" class="eva-date" value="<?php echo esc_attr( mysql2date( 'd/m/Y', current_time( 'mysql', 0 ), true ) ); ?>" name="dateFinAudit" /></span>
	<span class="padded"><input type="text" name="destinataireDUER" /></span>

	<span class="padded">
		<textarea class="hidden textarea-content-methodology" name="methodologie"><?php echo esc_html( $element->document_meta['methodologie'] ); ?></textarea>
		<span data-parent="wp-digi-societytree-right-container"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="fill_textarea_in_popup"
					data-title="Édition de la méthodologie"
					data-src="methodology"
					class="open-popup span-content-methodology"><?php echo esc_html( $element->document_meta['methodologie'] ); ?></span>
	</span>

	<span class="padded">
		<textarea class="hidden textarea-content-sources" name="sources"><?php echo esc_html( $element->document_meta['sources'] ); ?></textarea>
		<span data-parent="wp-digi-societytree-right-container"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="fill_textarea_in_popup"
					data-title="Édition de la source"
					data-src="sources"
					class="open-popup span-content-sources"><?php echo esc_html( $element->document_meta['sources'] ); ?></span>
		</span>

	<span class="padded">
		<textarea class="hidden textarea-content-notes-importantes" name="remarqueImportante"><?php echo esc_html( $element->document_meta['remarqueImportante'] ); ?></textarea>
		<span data-parent="wp-digi-societytree-right-container"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="fill_textarea_in_popup"
					data-title="Édition de la note importante"
					data-src="notes-importantes"
					class="open-popup span-content-notes-importantes"><?php echo esc_html( $element->document_meta['remarqueImportante'] ); ?></span>
	</span>

	<span class="padded"><input type="text" name="dispoDesPlans"/></span>
	<span class="wp-digi-action">
		<a href="#" class="wp-digi-action wp-digi-action-edit dashicons dashicons-plus" ></a>
	</span>
</li>
