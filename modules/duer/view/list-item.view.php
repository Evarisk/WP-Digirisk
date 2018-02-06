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
	<td class="padding"><?php echo esc_html( 'test' ); ?></td>
	<td class="padding"><?php echo esc_html( 'test' ); ?></td>

	<td class="padding padding text-center">
		<span class="hidden text-content-destinataire-duer"><?php echo esc_html( nl2br( 'test' ) ); // WPCS: XSS is ok. ?></span>
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
		<span class="hidden text-content-methodology"><?php echo nl2br(); // WPCS: XSS is ok. ?></span>
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
		<span class="hidden text-content-sources"><?php echo nl2br(); // WPCS: XSS is ok. ?></span>
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
		<span class="hidden text-content-dispo-des-plans"><?php echo nl2br(); // WPCS: XSS is ok. ?></span>
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
			<span class="hidden text-content-notes-importantes"><?php echo nl2br(); // WPCS: XSS is ok. ?></span>
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
			<?php if ( ! empty( $element->link ) ) : ?>
				<a class="button purple h50 tooltip hover"
					aria-label="<?php echo esc_attr_e( 'DUER', 'digirisk' ); ?>"
					href="<?php echo esc_attr( Document_Class::g()->get_document_path( $element->link ) ); ?>">
					<i class="fa fa-file-text-o" aria-hidden="true"></i>
				</a>
			<?php else : ?>
				<span class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'Corrompu', 'digirisk' ); ?>">
					<i class="fa fa-times icon" aria-hidden="true"></i>
				</span>
			<?php endif; ?>

			<?php echo apply_filters( 'digi_list_duer_single_item_action_end', '', $element ); ?>
		</div>
	</td>
</tr>
