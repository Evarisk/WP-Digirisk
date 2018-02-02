<?php
/**
 * Affichage d'un DUER
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.9
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr>
	<td class="padding w50"><strong><?php echo esc_html( $element->unique_identifier ); ?></strong></td>
	<td class="padding"><?php echo esc_html( $element->document_meta['dateDebutAudit']['rendered']['date'] ); ?></td>
	<td class="padding"><?php echo esc_html( $element->document_meta['dateFinAudit']['rendered']['date'] ); ?></td>

	<td class="padding padding text-center">
		<span class="hidden text-content-destinataire-duer"><?php echo esc_html( nl2br( $element->document_meta['destinataireDUER'] ) ); // WPCS: XSS is ok. ?></span>
		<span data-parent="main-content"
					data-target="popup"
					data-cb-namespace="digirisk"
					data-cb-object="DUER"
					data-cb-func="view_in_popup"
					data-title="Destinataire"
					data-src="destinataire-duer"
					class="fa-layers fa-fw open-popup float-icon">

			<i class="fas fa-square background-icon"></i>
			<i class="fas fa-user" data-fa-transform="shrink-10"></i>
			<span class="animated-icon animated">
				<i class="far fa-eye"></i>
			</span>
		</span>
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
					class="fa-layers fa-fw open-popup float-icon">

			<i class="fas fa-square background-icon"></i>
			<i class="fas fa-search" data-fa-transform="shrink-10"></i>
			<span class="animated-icon animated">
				<i class="far fa-eye"></i>
			</span>
		</span>
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
					class="fa-layers fa-fw open-popup float-icon">

			<i class="fas fa-square background-icon"></i>
			<i class="fas fa-link" data-fa-transform="shrink-10"></i>
			<span class="animated-icon animated">
				<i class="far fa-eye"></i>
			</span>
		</span>
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
					class="fa-layers fa-fw open-popup float-icon">

			<i class="fas fa-square background-icon"></i>
			<i class="fas fa-map-marker-alt" data-fa-transform="shrink-10"></i>
			<span class="animated-icon animated">
				<i class="far fa-eye"></i>
			</span>
		</span>
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
						class="fa-layers fa-fw open-popup float-icon">

				<i class="fas fa-square background-icon"></i>
				<i class="fas fa-file" data-fa-transform="shrink-10"></i>
				<span class="animated-icon animated">
					<i class="far fa-eye"></i>
				</span>
			</span>
		</td>

	<td>
		<div class="action grid-layout w2">
			<?php if ( ! empty( Document_Class::g()->get_document_path( $element ) ) ) : ?>
				<a class="button purple h50 tooltip hover"
					aria-label="<?php echo esc_attr_e( 'DUER', 'digirisk' ); ?>"
					href="<?php echo esc_attr( Document_Class::g()->get_document_path( $element ) ); ?>"><i class="icon fas fa-file-alt"></i></a>
			<?php else : ?>
				<span class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'Corrompu', 'digirisk' ); ?>" href="<?php echo esc_attr( Document_Class::g()->get_document_path( $element ) ); ?>">
					<i class="far fa-times icon" aria-hidden="true"></i>
				</span>
			<?php endif; ?>

			<?php echo apply_filters( 'digi_list_duer_single_item_action_end', '', $element ); ?>
		</div>
	</td>
</tr>
