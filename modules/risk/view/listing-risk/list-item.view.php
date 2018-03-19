<?php
/**
 * Gestion de l'affichage d'un listing de risque.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr>
	<td class="padding"><strong><?php echo esc_html( $element->unique_identifier ); ?></strong></td>
	<td class="padding"><?php echo esc_html( $element->title ); ?></td>
	<td>
		<div class="action grid-layout w1">
			<div></div>
			<div>
				<?php if ( ! empty( Document_Class::g()->get_document_path( $element ) ) ) : ?>
					<a class="button purple h50" href="<?php echo esc_attr( Document_Class::g()->get_document_path( $element ) ); ?>">
						<i class="fa fa-download icon" aria-hidden="true"></i>
						<!-- <span><?php esc_html_e( 'Listing de risque', 'digirisk' ); ?></span> -->
					</a>
				<?php else : ?>
					<span class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'Corrompu', 'digirisk' ); ?>" href="<?php echo esc_attr( Document_Class::g()->get_document_path( $element ) ); ?>">
						<i class="fa fa-times icon" aria-hidden="true"></i>
					</span>
				<?php endif; ?>
			</div>
		</div>
	</td>
</tr>
