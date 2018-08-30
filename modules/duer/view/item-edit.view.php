<?php
/**
 * Édition d'un DUER
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.1.9
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr>
	<input type="hidden" name="element_id" value="<?php echo esc_attr( $element_id ); ?>" />

	<td class="padding"></td>
	<td class="padding">
		<div class="group-date form-element">
			<input type="hidden" class="mysql-date" name="dateDebutAudit" value="<?php echo esc_attr( current_time( 'mysql' ) ); ?>" />
			<input type="text" class="date" value="<?php echo esc_attr( $element->data['document_meta']['dateDebutAudit']['rendered']['date'] ); ?>" />
		</div>
	</td>
	<td class="padding">
		<div class="group-date form-element">
			<input type="hidden" class="mysql-date" name="dateFinAudit" value="<?php echo esc_attr( current_time( 'mysql' ) ); ?>" />
			<input type="text" class="date" value="<?php echo esc_attr( $element->data['document_meta']['dateDebutAudit']['rendered']['date'] ); ?>" />
		</div>
	</td>

	<td class="padding">
		<textarea class="hidden textarea-content-destinataire-duer" name="destinataireDUER"><?php echo esc_html( $element->data['document_meta']['destinataireDUER'] ); ?></textarea>
		<span data-parent="main-container"
				data-target="duer-modal"
				data-title="Édition du destinataire"
				data-src="destinataire-duer"
				class="fa-layers fa-fw wpeo-modal-event float-icon span-content-destinataire-duer">

			<i class="fas fa-square background-icon"></i>
			<i class="fas fa-user" data-fa-transform="shrink-10"></i>
			<span class="animated-icon animated">
				<i class="fas fa-pencil"></i>
			</span>
		</span>
	</td>

	<td class="padding">
		<textarea class="hidden textarea-content-methodology" name="methodologie"><?php echo esc_html( $element->data['document_meta']['methodologie'] ); ?></textarea>
		<span data-parent="main-container"
					data-target="duer-modal"
					data-title="Édition de la méthodologie"
					data-src="methodology"
					class="fa-layers fa-fw wpeo-modal-event float-icon span-content-methodology">

			<i class="fas fa-square background-icon"></i>
			<i class="fas fa-search" data-fa-transform="shrink-10"></i>
			<span class="animated-icon animated">
				<i class="fas fa-pencil"></i>
			</span>
		</span>
	</td>

	<td class="padding">
		<textarea class="hidden textarea-content-sources" name="sources"><?php echo esc_html( $element->data['document_meta']['sources'] ); ?></textarea>
		<span data-parent="main-container"
					data-target="duer-modal"
					data-title="Édition de la source"
					data-src="sources"
					class="fa-layers fa-fw wpeo-modal-event float-icon span-content-sources">

			<i class="fas fa-square background-icon"></i>
			<i class="fas fa-link" data-fa-transform="shrink-10"></i>
			<span class="animated-icon animated">
				<i class="fas fa-pencil"></i>
			</span>
		</span>
	</td>

	<td class="padding">
		<textarea class="hidden textarea-content-dispo-des-plans" name="dispoDesPlans"><?php echo esc_html( $element->data['document_meta']['dispoDesPlans'] ); ?></textarea>
		<span data-parent="main-container"
					data-target="duer-modal"
					data-title="Édition de la localisation"
					data-src="dispo-des-plans"
					class="fa-layers fa-fw wpeo-modal-event float-icon span-content-dispo-des-plans">

			<i class="fas fa-square background-icon"></i>
			<i class="fas fa-map-marker-alt" data-fa-transform="shrink-10"></i>
			<span class="animated-icon animated">
				<i class="fas fa-pencil"></i>
			</span>
		</span>
	</td>

	<td class="padding">
		<textarea class="hidden textarea-content-notes-importantes" name="remarqueImportante"><?php echo esc_html( $element->data['document_meta']['remarqueImportante'] ); ?></textarea>
		<span data-parent="main-container"
					data-target="duer-modal"
					data-title="Édition de la note importante"
					data-src="notes-importantes"
					class="fa-layers fa-fw wpeo-modal-event float-icon span-content-notes-importantes">

			<i class="fas fa-square background-icon"></i>
			<i class="fas fa-file" data-fa-transform="shrink-10"></i>
			<span class="animated-icon animated">
				<i class="fas fa-pencil"></i>
			</span>
		</span>
	</td>

	<td>
		<div class="action w50">
			<div class="wpeo-modal-event add button blue w50"
					data-id="<?php echo esc_attr( $element_id ); ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_societies_duer' ) ); ?>"
					data-action="display_societies_duer"
					data-class="generate-duer-modal modal-force-display"
					data-title="Génération du DUER">
					<i class="icon far fa-plus"></i>
				</div>
		</div>
	</td>

</tr>
