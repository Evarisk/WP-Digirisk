<?php
/**
 * Gestion de l'affichage d'une fiche de poste
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
	<td class="padding"><strong><?php echo esc_html( $element->unique_identifier ); ?></strong></td>
	<td class="padding"><?php echo esc_html( $element->title ); ?></td>
	<td>
		<div class="action">
			<?php if ( ! empty( $element->link ) ) : ?>
			<a class="button purple h50" href="<?php echo esc_attr( $element->link ); ?>">
				<i class="fas fa-download icon" aria-hidden="true"></i>
			</a>
		<?php else : ?>
			<span class="button grey h50 tooltip hover" aria-label="<?php echo esc_attr_e( 'Corrompu', 'digirisk' ); ?>">
				<i class="far fa-times icon" aria-hidden="true"></i>
			</span>
		<?php endif; ?>
		</div>
	</td>
</tr>
