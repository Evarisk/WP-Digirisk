<?php
/**
 * Affichage d'un DUER
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.1.9
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr>
	<td class="padding w50"><strong><?php echo esc_html( $element->data['unique_identifier'] ); ?></strong></td>
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
					class="fa-layers fa-fw open-popup float-icon">

			<i class="fas fa-square background-icon"></i>
			<i class="fas fa-user" data-fa-transform="shrink-10"></i>
			<span class="animated-icon animated">
				<i class="far fa-eye"></i>
			</span>
		</span>
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
					class="fa-layers fa-fw open-popup float-icon">

			<i class="fas fa-square background-icon"></i>
			<i class="fas fa-search" data-fa-transform="shrink-10"></i>
			<span class="animated-icon animated">
				<i class="far fa-eye"></i>
			</span>
		</span>
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
					class="fa-layers fa-fw open-popup float-icon">

			<i class="fas fa-square background-icon"></i>
			<i class="fas fa-link" data-fa-transform="shrink-10"></i>
			<span class="animated-icon animated">
				<i class="far fa-eye"></i>
			</span>
		</span>
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
					class="fa-layers fa-fw open-popup float-icon">

			<i class="fas fa-square background-icon"></i>
			<i class="fas fa-map-marker-alt" data-fa-transform="shrink-10"></i>
			<span class="animated-icon animated">
				<i class="far fa-eye"></i>
			</span>
		</span>
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
			<?php if ( ! empty( $element->data['link'] ) ) : ?>
				<a class="button purple h50 tooltip hover"
					aria-label="<?php echo esc_attr_e( 'DUER', 'digirisk' ); ?>"
					href="<?php echo esc_attr( $element->data['link'] ); ?>">
					<i class="icon fas fa-file-alt"></i>
				</a>
			<?php else : ?>
				<span class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'Corrompu', 'digirisk' ); ?>">
					<i class="far fa-times icon" aria-hidden="true"></i>
				</span>
			<?php endif; ?>

			<?php echo apply_filters( 'digi_list_duer_single_item_action_end', '', $element ); ?>
		</div>
	</td>
</tr>
