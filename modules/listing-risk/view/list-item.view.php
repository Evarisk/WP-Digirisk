<?php
/**
 * Gestion de l'affichage d'un listing de risque.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.5.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr>
	<td class="padding"><strong><?php echo esc_html( $element->data['unique_identifier'] ); ?></strong></td>
	<td class="padding"><?php echo esc_html( $element->data['title'] ); ?></td>
	<td>
		<div class="action grid-layout w1">
			<div></div>
			<div>
				<?php if ( ! empty( Document_Class::g()->get_document_path( $element, 'digi-group' ) ) ) : ?>
					<a class="button purple h50" href="<?php echo esc_attr( Document_Class::g()->get_document_path( $element, 'digi-group' ) ); ?>">
						<i class="fa fa-download icon" aria-hidden="true"></i>
					</a>
				<?php else : ?>
					<span class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'Corrompu', 'digirisk' ); ?>">
						<i class="fa fa-times icon" aria-hidden="true"></i>
					</span>
				<?php endif; ?>
			</div>
		</div>
	</td>
</tr>
