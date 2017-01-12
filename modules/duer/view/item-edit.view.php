<?php
/**
 * Gestion du formulaire pour générer un DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package document
 * @subpackage view
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<tr>
	<input type="hidden" name="action" value="generate_duer" />
	<?php wp_nonce_field( 'callback_ajax_generate_duer' ); ?>
	<input type="hidden" name="element_id" value="<?php echo esc_attr( $element_id ); ?>" />

	<td></td>
	<td><input type="text" class="eva-date" value="<?php echo esc_attr( mysql2date( 'd/m/Y', current_time( 'mysql', 0 ), true ) ); ?>" name="dateDebutAudit" /></td>
	<td><input type="text" class="eva-date" value="<?php echo esc_attr( mysql2date( 'd/m/Y', current_time( 'mysql', 0 ), true ) ); ?>" name="dateFinAudit" /></td>

	<td class="padded">
		<textarea class="hidden textarea-content-destinataire-duer" name="destinataireDUER"><?php echo esc_html( $element->document_meta['destinataireDUER'] ); ?></textarea>
		<span data-parent="main-content"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="fill_textarea_in_popup"
					data-title="Édition du destinataire"
					data-src="destinataire-duer"
					class="open-popup span-content-destinataire-duer"><span class="dashicons dashicons-admin-users"></span></span>
	</td>

	<td class="padded">
		<textarea class="hidden textarea-content-methodology" name="methodologie"><?php echo esc_html( $element->document_meta['methodologie'] ); ?></textarea>
		<span data-parent="main-content"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="fill_textarea_in_popup"
					data-title="Édition de la méthodologie"
					data-src="methodology"
					class="open-popup span-content-methodology"><span class="dashicons dashicons-search"></span></span>
	</td>

	<td class="padded">
		<textarea class="hidden textarea-content-sources" name="sources"><?php echo esc_html( $element->document_meta['sources'] ); ?></textarea>
		<span data-parent="main-content"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="fill_textarea_in_popup"
					data-title="Édition de la source"
					data-src="sources"
					class="open-popup span-content-sources"><span class="dashicons dashicons-admin-links"></span></span>
	</td>

	<td class="padded">
		<textarea class="hidden textarea-content-notes-importantes" name="remarqueImportante"><?php echo esc_html( $element->document_meta['remarqueImportante'] ); ?></textarea>
		<span data-parent="main-content"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="fill_textarea_in_popup"
					data-title="Édition de la note importante"
					data-src="notes-importantes"
					class="open-popup span-content-notes-importantes"><span class="dashicons dashicons-clipboard"></span></span>
	</td>

	<td class="padded">
		<textarea class="hidden textarea-content-dispo-des-plans" name="dispoDesPlans"><?php echo esc_html( $element->document_meta['dispoDesPlans'] ); ?></textarea>
		<span data-parent="main-content"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="fill_textarea_in_popup"
					data-title="Édition de la disposition des plans"
					data-src="dispo-des-plans"
					class="open-popup span-content-dispo-des-plans"><span class="dashicons dashicons-location"></span></span>
	</td>

	<td class="wp-digi-action">
		<a href="#" class="open-popup dashicons dashicons-plus"
				data-id="<?php echo esc_attr( $element_id ); ?>"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_societies_duer' ) ); ?>"
				data-parent="main-content"
				data-target="popup"
				data-cb-object="DUER"
				data-cb-func="popup_for_generate_DUER"
				data-title="Génération du DUER"></a>
	</td>

</tr>
