<?php
/**
 * Ce template affiche un "DUER" dans le tableau des DUER.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.1.9
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<tr>
	<td class="padding w50"><strong><?php echo esc_html( $document->data['unique_identifier'] ); ?></strong></td>
	<td class="padding"><?php echo esc_html( $document->data['document_meta']['dateDebutAudit']['rendered']['date'] ); ?></td>
	<td class="padding"><?php echo esc_html( $document->data['document_meta']['dateFinAudit']['rendered']['date'] ); ?></td>

	<td class="padding padding text-center">
		<span class="hidden text-content-destinataire-duer"><?php echo nl2br( $document->data['document_meta']['destinataireDUER'] ); // WPCS: XSS is ok. ?></span>
		<span data-parent="main-container"
					data-type="view"
					data-target="duer-modal"
					data-title="Destinataire"
					data-src="destinataire-duer"
					class="wpeo-modal-event wpeo-button-pulse">

			<i class="button-icon fas fa-user"></i>
			<span class="button-float-icon animated"><i class="fas fa-eye"></i></span>
		</span>
	</td>

	<td class="padding text-center">
		<span class="hidden text-content-methodology"><?php echo nl2br( $document->data['document_meta']['methodologie'] ); // WPCS: XSS is ok. ?></span>
		<span data-parent="main-container"
					data-type="view"
					data-target="duer-modal"
					data-title="Méthodologie"
					data-src="methodology"
					class="wpeo-modal-event wpeo-button-pulse">

			<i class="button-icon fas fa-search"></i>
			<span class="button-float-icon animated"><i class="fas fa-eye"></i></span>
		</span>
	</td>

	<td class="padding text-center">
		<span class="hidden text-content-sources"><?php echo nl2br( $document->data['document_meta']['sources'] ); // WPCS: XSS is ok. ?></span>
		<span data-parent="main-container"
					data-type="view"
					data-target="duer-modal"
					data-title="Source"
					data-src="sources"
					class="wpeo-modal-event wpeo-button-pulse">

			<i class="button-icon fas fa-link"></i>
			<span class="button-float-icon animated"><i class="fas fa-eye"></i></span>
		</span>
		</td>

	<td class="padding text-center">
		<span class="hidden text-content-dispo-des-plans"><?php echo nl2br( $document->data['document_meta']['dispoDesPlans'] ); // WPCS: XSS is ok. ?></span>
		<span data-parent="main-container"
					data-type="view"
					data-target="duer-modal"
					data-title="Disponibilité des plans"
					data-src="dispo-des-plans"
					class="wpeo-modal-event wpeo-button-pulse">

			<i class="button-icon fas fa-map-marker-alt"></i>
			<span class="button-float-icon animated"><i class="fas fa-eye"></i></span>
		</span>
	</td>

		<td class="padding text-center">
			<span class="hidden text-content-notes-importantes"><?php echo nl2br( $document->data['document_meta']['remarqueImportante'] ); // WPCS: XSS is ok. ?></span>
			<span data-parent="main-container"
						data-type="view"
						data-target="duer-modal"
						data-title="Note importante"
						data-src="notes-importantes"
						class="wpeo-modal-event wpeo-button-pulse">

				<i class="button-icon fas fa-file"></i>
				<span class="button-float-icon animated"><i class="fas fa-eye"></i></span>
			</span>
		</td>

	<td>
		<div class="action wpeo-gridlayout grid-2 grid-gap-0">
			<?php if ( ! empty( $document->data['file_generated'] ) ) : ?>
				<a class="wpeo-button button-purple button-square-50 wpeo-tooltip-event"
					aria-label="<?php echo esc_attr_e( 'DUER', 'digirisk' ); ?>"
					href="<?php echo esc_attr( $document->data['link'] ); ?>">
					<i class="icon fas fa-file-alt"></i>
				</a>
			<?php else : ?>
				<span class="action-attribute wpeo-button button-grey button-square-50 wpeo-tooltip-event"
					data-id="<?php echo esc_attr( $document->data['id'] ); ?>"
					data-model="<?php echo esc_attr( $document->get_class() ); ?>"
					data-action="generate_document"
					data-color="red"
					data-direction="left"
					aria-label="<?php echo esc_attr_e( 'Corrompu. Cliquer pour regénérer.', 'digirisk' ); ?>">
					<i class="fas fa-times icon" aria-hidden="true"></i>
				</span>
			<?php endif; ?>

			<?php echo apply_filters( 'digi_list_duer_single_item_action_end', '', $document ); ?>
		</div>
	</td>
</tr>
