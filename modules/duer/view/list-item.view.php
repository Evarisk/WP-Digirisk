<?php
/**
 * Affichage d'un DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package duer
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

?>

<tr>
	<td class="padding w50"><strong><?php echo esc_html( $element->unique_identifier ); ?></strong></td>
	<td class="padding"><?php echo esc_html( $element->document_meta['dateDebutAudit'] ); ?></td>
	<td class="padding"><?php echo esc_html( $element->document_meta['dateFinAudit'] ); ?></td>

	<td class="padding padding text-center">
		<span class="hidden text-content-destinataire-duer"><?php echo esc_html( nl2br( $element->document_meta['destinataireDUER'] ) ); // WPCS: XSS is ok. ?></span>
		<span data-parent="main-content"
					data-target="popup"
					data-cb-namespace="digirisk"
					data-cb-object="DUER"
					data-cb-func="view_in_popup"
					data-title="Destinataire"
					data-src="destinataire-duer"
					class="open-popup button grey radius w30"><i class="float-icon fa fa-eye animated"></i><span class="dashicons dashicons-admin-users"></span></span>
	</td>

	<td class="padding text-center">
		<span class="hidden text-content-methodology"><?php echo nl2br( $element->document_meta['methodologie'] ); // WPCS: XSS is ok. ?></span>
		<span data-parent="main-content"
					data-target="popup"
					data-cb-namespace="digirisk"
					data-cb-object="DUER"
					data-cb-func="view_in_popup"
					data-title="Méthodologie"
					data-src="methodology"
					class="open-popup button grey radius w30"><i class="float-icon fa fa-eye animated"></i><span class="dashicons dashicons-search"></span></span>
	</td>

	<td class="padding text-center">
		<span class="hidden text-content-sources"><?php echo nl2br( $element->document_meta['sources'] ); // WPCS: XSS is ok. ?></span>
		<span data-parent="main-content"
					data-target="popup"
					data-cb-namespace="digirisk"
					data-cb-object="DUER"
					data-cb-func="view_in_popup"
					data-title="Source"
					data-src="sources"
					class="open-popup button grey radius w30"><i class="float-icon fa fa-eye animated"></i><span class="dashicons dashicons-admin-links"></span></span>
		</td>

	<td class="padding text-center">
		<span class="hidden text-content-dispo-des-plans"><?php echo nl2br( $element->document_meta['dispoDesPlans'] ); // WPCS: XSS is ok. ?></span>
		<span data-parent="main-content"
					data-target="popup"
					data-cb-namespace="digirisk"
					data-cb-object="DUER"
					data-cb-func="view_in_popup"
					data-title="Disponibilité des plans"
					data-src="dispo-des-plans"
					class="open-popup button grey radius w30"><i class="float-icon fa fa-eye animated"></i><span class="dashicons dashicons-location"></span></span>
	</td>

		<td class="padding text-center">
			<span class="hidden text-content-notes-importantes"><?php echo nl2br( $element->document_meta['remarqueImportante'] ); // WPCS: XSS is ok. ?></span>
			<span data-parent="main-content"
						data-target="popup"
						data-cb-namespace="digirisk"
						data-cb-object="DUER"
						data-cb-func="view_in_popup"
						data-title="Note importante"
						data-src="notes-importantes"
						class="open-popup button grey radius w30"><i class="float-icon fa fa-eye animated"></i><span class="dashicons dashicons-clipboard"></span></span>
		</td>

	<td>
		<div class="action grid-layout w2">
				<a class="button red h50" href="<?php echo esc_attr( document_class::g()->get_document_path( $element ) ); ?>">
					<i class="fa fa-download" aria-hidden="true"></i>
					<span><?php esc_html_e( 'DUER', 'digirisk' ); ?></span>
				</a>

			<?php echo apply_filters( 'digi_list_duer_single_item_action_end', '', $element ); ?>
		</div>
	</td>
</tr>
