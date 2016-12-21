<?php
/**
 * Gestion de l'affichage d'un DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.1.9.0
 * @copyright 2015-2016 Evarisk
 * @package document
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<li class='wp-digi-list-item wp-digi-risk-item'>
	<span><?php echo esc_html( $element->unique_identifier ); ?></span>
	<span class="padded"><?php echo esc_html( mysql2date( 'd/m/Y', $element->document_meta['dateDebutAudit'], true ) ); ?></span>
	<span class="padded"><?php echo esc_html( mysql2date( 'd/m/Y', $element->document_meta['dateFinAudit'], true ) ); ?></span>

	<span class="text-center">
		<span class="hidden text-content-destinataire-duer"><?php echo esc_html( $element->document_meta['destinataireDUER'] ); ?></span>
		<span data-parent="wp-digi-societytree-right-container"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="view_in_popup"
					data-title="Destinataire"
					data-src="destinataire-duer"
					class="open-popup"><span class="dashicons dashicons-admin-users"></span></span>
	</span>

	<span class="text-center">
		<span class="hidden text-content-methodology"><?php echo esc_html( $element->document_meta['methodologie'] ); ?></span>
		<span data-parent="wp-digi-societytree-right-container"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="view_in_popup"
					data-title="Méthodologie"
					data-src="methodology"
					class="open-popup"><span class="dashicons dashicons-search"></span></span>
	</span>

	<span class="text-center">
		<span class="hidden text-content-sources"><?php echo esc_html( $element->document_meta['sources'] ); ?></span>
		<span data-parent="wp-digi-societytree-right-container"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="view_in_popup"
					data-title="Source"
					data-src="sources"
					class="open-popup"><span class="dashicons dashicons-admin-links"></span></span>
		</span>

	<span class="text-center">
		<span class="hidden text-content-notes-importantes"><?php echo esc_html( $element->document_meta['remarqueImportante'] ); ?></span>
		<span data-parent="wp-digi-societytree-right-container"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="view_in_popup"
					data-title="Note importante"
					data-src="notes-importantes"
					class="open-popup"><span class="dashicons dashicons-clipboard"></span></span>
	</span>

	<span class="text-center">
		<span class="hidden text-content-dispo-des-plans"><?php echo esc_html( $element->document_meta['dispoDesPlans'] ); ?></span>
		<span data-parent="wp-digi-societytree-right-container"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="view_in_popup"
					data-title="Disponibilité des plans"
					data-src="dispo-des-plans"
					class="open-popup"><span class="dashicons dashicons-location"></span></span>
	</span>

	<span class="padded flex-tmp">
		<a href="<?php echo esc_attr( document_class::g()->get_document_path( $element ) ); ?>">
			<i class="fa fa-download" aria-hidden="true"></i>
			<?php esc_html_e( 'DUER', 'digirisk' ); ?>
		</a>

		<?php echo apply_filters( 'digi_list_duer_single_item_action_end', '', $element ); ?>
	</span>
</li>
