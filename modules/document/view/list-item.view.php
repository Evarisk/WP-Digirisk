<?php
/**
 * Affichage d'une ligne contenant les informations et le lien de téléchargement d'un document.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
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
	<td class="padding"><strong><?php echo esc_html( $element->data['unique_identifier'] ); ?></strong></td>
	<td class="padding"><?php echo esc_html( $element->data['title'] ); ?></td>
	<td>
		<div class="action">
			<?php if ( $element->data['file_generated'] ) : ?>
				<a class="wpeo-button button-purple button-square-50" href="<?php echo esc_attr( $element->data['link'] ); ?>">
					<i class="fas fa-download icon" aria-hidden="true"></i>
				</a>
			<?php else : ?>
				<span class="action-attribute wpeo-button button-grey button-square-50 wpeo-tooltip-event"
					data-id="<?php echo esc_attr( $element->data['id'] ); ?>"
					data-model="<?php echo esc_attr( $element->get_class() ); ?>"
					data-action="generate_document"
					data-color="red"
					data-direction="left"
					aria-label="<?php echo esc_attr_e( 'Corrompu. Cliquer pour regénérer.', 'digirisk' ); ?>">
					<i class="fas fa-times icon" aria-hidden="true"></i>
				</span>
			<?php endif; ?>
		</div>
	</td>
</tr>
